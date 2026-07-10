<?php

require_once 'solr.config.php';

class SolrRequest
{

    private $client;

    private $query;

    private $searchFields = ['specialites', 'types_pedagogiques', 'niveaux'];

    public function __construct()
    {
        $this->client = new SolrClient([
            'hostname' => SOLR_HOSTNAME,
            'port' => SOLR_PORT,
            'path' => SOLR_PATH,
        ]);

        $this->query = new SolrQuery();
    }

    /**
     * @return mixed
     */
    public function solrFacetsQuery()
    {
        $this->query->setQuery('*:*');
        $this->query->setRows(100000);
        $this->query->setFacet(true);
        $this->query->addField('discipline_facet')->addField('niveaux')->addField('types_pedagogiques');

        return $this->client->query($this->query)->getResponse();
    }

    /**
     * @param $get
     *
     * @return mixed
     */
    public function solrListeQuery($get, $page)
    {
        $this->query->setQuery('*:*');
        $this->query->setRows(ROWS_PER_PAGE);
        $this->generateStartSolrPage($page);
        $this->generateQuery($get);

        return $this->client->query($this->query)->getResponse();
    }

    /**
     * @param $get
     *
     * @return void
     */
    private function generateQuery($get): void
    {
        if (isset($get['recherche']) && ! empty($get['recherche'])) {
            $this->query->setQuery('titre:*' . GenerateFacets::escapeSolrValue($get['recherche']) . '*');
        }

        if (isset($get['specialites']) || isset($get['niveaux']) || isset($get['types_pedagogiques'])) {
            foreach ($this->searchFields as $field) {
                $this->generalSolrFilter($get, $field);
            }
        }

        if (isset($get['tri']) && ! empty($get['tri'])) {
            $tri = sanitize_post($get['tri']);
            $this->query->addSortField('date_modification',
                $tri === 'date+' ? SolrQuery::ORDER_ASC : SolrQuery::ORDER_DESC);
        } else {
            $this->query->addSortField('date_modification', SolrQuery::ORDER_DESC);
        }
    }

    /**
     * @param $get
     * @param $field
     *
     * @return void
     */
    private function generalSolrFilter($get, $field): void
    {
        $likeCharacter = $field === 'specialites' ? '*' : '';
        if (is_array($get[$field])) {
            if (count($get[$field]) === 1) {
                $newField = base64_decode($get[$field][0]);
                $field = $field === 'specialites' ? 'discipline_facet' : $field;
                $this->query->addFilterQuery($field . ":" . $likeCharacter . GenerateFacets::escapeSolrValue($newField)
                    . $likeCharacter);
            } else {
                $multi = [];
                foreach ($get[$field] as $newField) {
                    $cleanField = base64_decode($newField);
                    if ($field === 'specialites') {
                        $cleanField = $this->cleanSubSpecilitesField($cleanField);
                    }
                    $multi[] = $likeCharacter . GenerateFacets::escapeSolrValue($cleanField) . $likeCharacter;
                }
                $this->query->addFilterQuery($field . ":(" . implode(' OR ', $multi) . ")");
            }
        }
    }

    /**
     * @param $pageNumber
     *
     * @return void
     */
    private function generateStartSolrPage($pageNumber): void
    {
        $start = $pageNumber === 1 ? 0 : ($pageNumber * ROWS_PER_PAGE) - ROWS_PER_PAGE;
        $this->query->setStart($start);
    }

    /**
     * @param $uuid
     *
     * @return array|mixed
     */
    public function getFiche($uuid): array
    {
        $fiche = [];
        $res = $this->solrRequestFiche($uuid);
        if ($res['response']['numFound'] === 1) {
            $fiche = $res['response']['docs'][0];
            $fiche = [
                'contributeur' => implode(', ', $fiche->auteurs_facet),
                'keyWords' => implode(', ', $fiche->mots_cles),
                'levels' => implode(', ', $fiche->niveaux),
                'types_pedagogiques' => implode(', ', $fiche->types_pedagogiques),
                'types_documentaires' => implode(', ', $fiche->types_documentaires),
                'dure_apprentissage' => ! empty($fiche->dure_apprentissage)
                    ? $this->setDuree($fiche->dure_apprentissage) : $this->setDuree($fiche->dure_execution),
                'proposition_utilisation' => $fiche->proposition_utilisation[0],
                'associations_associate' => $this->setAssociates($fiche->associations_associate),
                'titre' => $fiche->titre[0],
                'date_publication' => wp_date('d/m/Y', strtotime($fiche->date_publication)),
                'description' => $fiche->description_text,
                'droit' => $fiche->droit,
                'logo_droit' => $this->setDroitImg($fiche->droit),
                'lien' => $fiche->ressource_liens[0],
                'disciplines' => implode(', ', $fiche->specialites),
                'porteur' => $this->setPorteur($fiche),
                'langues' => $this->setLangues($fiche),
                'vignette' => isset($fiche->vignette) ? 'https://ressources.luniversitenumerique.fr/uploads/images/'
                    . $fiche->vignette : '',
                'numFound' => $res['response']['numFound'],
                'suplom' => 'https://oai.luniversitenumerique.fr/joai/provider?verb=GetRecord&metadataPrefix=suplomfr&identifier=sf_'
                    . $uuid,
            ];
        }

        return $fiche;
    }

    /**
     * @param $uuid
     *
     * @return mixed
     */
    private function solrRequestFiche($uuid): mixed
    {
        $this->query->setQuery('uuid:' . $uuid);

        return $this->client->query($this->query)->getResponse();
    }

    /**
     * @param $fiche
     *
     * @return string|null
     */
    private function setPorteur($fiche): ?string
    {
        $porteurData = $fiche->etablissement_porteur;

        if (empty($porteurData)) {
            return null;
        }

        if (is_string($porteurData)) {
            $decoded = json_decode($porteurData);
            // Valid JSON.
            if (json_last_error() === JSON_ERROR_NONE) {
                $porteurData = $decoded;
            } else {
                return $porteurData;
            }
        }

        if (is_array($porteurData)) {
            // Array of strings.
            if (array_is_list($porteurData)) {
                return implode(', ', $porteurData);
            }
            // Associative array.
            $libelle = $porteurData['libelle'] ?? null;
        } elseif (is_object($porteurData)) {
            $libelle = $porteurData->libelle ?? null;
        } else {
            return null;
        }

        if (is_array($libelle)) {
            return implode(', ', $libelle);
        }

        return is_string($libelle) && $libelle !== '' ? $libelle : null;
    }

    /**
     * @param $fiche
     *
     * @return string
     */
    private function setLangues($fiche): string
    {
        $languesFiche = isset($fiche->langues_ressource) ? $fiche->langues_ressource : $fiche->langues_utilisateur;
        $langCor = [
            'fre' => 'français',
            'eng' => 'anglais',
            'oci' => 'occitan',
            'lat' => 'latin',
            'grc' => 'grec',
            'ara' => 'arabe',
            'spa' => 'espagnol',
            'deu' => 'allemand',
            'cpf' => 'créole',
            'ita' => 'italien',
            'por' => 'portugais',
            'pol' => 'polonais',
        ];
        $langues = [];
        foreach ($languesFiche as $lf) {
            $langues[] = $langCor[$lf];
        }

        return ucfirst(implode(', ', $langues));
    }

    private function setDuree($duree)
    {
        if (! empty($duree)) {
            $duree = mb_substr($duree, 2, mb_strlen($duree));

            return strtolower($duree);
        }

        return $duree;
    }

    private function setAssociates($associates)
    {
        if (isset($associates[0])) {
            $returnAssociates = [];
            foreach ($associates as $ass) {
                $returnAssociates[] = json_decode($ass);
            }

            return $returnAssociates;
        }

        return $associates;
    }

    private function setDroitImg($droit)
    {
        $droitToImage = [
            'Licence Creative Commons CC BY-NC-ND (Attribution – Pas d’utilisation commerciale – Pas de modifications)' => [
                'img' => 'by-nc-nd.webp', 'lien' => 'https://creativecommons.org/licenses/by-nc-nd/4.0/',
            ]
            ,
            'Licence Creative Commons CC BY-NC (Attribution – Pas d’utilisation commerciale)' => [
                'img' => 'by-nc.webp', 'lien' => 'https://creativecommons.org/licenses/by-nc/4.0/',
            ]
            ,
            'Tous droits réservés' => ['img' => 'droits-reserves-editeurs.png', 'lien' => ''],

            'Licence Creative Commons CC BY-NC-SA (Attribution – Pas d’utilisation commerciale – Partage dans les mêmes conditions.' => [
                'img' => 'by-nc-sa.webp', 'lien' => 'https://creativecommons.org/licenses/by-nc-sa/4.0/',
            ]
            ,

            'Licence CeCILL version 2' => [
                'img' => 'bancecill.webp',
                'lien' => 'https://cecill.info/licences/Licence_CeCILL_V2-fr.html',
            ],

            'Licence Creative Commons CC BY (Attribution)' => [
                'img' => 'by.webp',
                'lien' => 'https://creativecommons.org/licenses/by/4.0/',
            ],

            'Licence Creative Commons CC BY-ND (Attribution – Pas de modification)' => [
                'img' => 'by-nd.webp', 'lien' => 'https://creativecommons.org/licenses/by-nd/4.0/',
            ],

            'Licence Creative Commons CC BY-SA (Attribution – Partage dans les mêmes conditions)' => [
                'img' => 'by-sa.webp', 'lien' => 'https://creativecommons.org/licenses/by-sa/4.0/',

            ],

            'Paternité Pas d\'utilisation commerciale Pas de modification' => [
                'img' => 'by-nc-nd.webp', 'lien' => 'https://creativecommons.org/licenses/by-nc-nd/4.0/',
            ],

        ];

        return $droitToImage[$droit];
    }
}