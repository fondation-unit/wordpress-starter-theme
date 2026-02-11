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
                    $newField = base64_decode($newField);
                    $multi[] = $likeCharacter . GenerateFacets::escapeSolrValue($newField) . $likeCharacter;
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
            $contributions = json_decode($fiche->contributions[0]);
            $fiche = [
                'contributeur' => $contributions->prenom . ' ' . $contributions->nom,
                'keyWords' => implode(', ', $fiche->mots_cles),
                'levels' => implode(', ', $fiche->niveaux),
                'titre' => $fiche->titre[0],
                'date_publication' => wp_date('d/m/Y', strtotime($fiche->date_publication)),
                'description' => $fiche->description[0],
                'droits' => $fiche->droit,
                'lien' => $fiche->ressource_liens[0],
                'disciplines' => implode(', ', $fiche->specialites),
                'porteur' => $this->setPorteur($fiche),
                'langues' => $this->setLangues($fiche),
                'vignette' => isset($fiche->vignette) ? 'https://ressources.luniversitenumerique.fr/uploads/images/'.$fiche->vignette : '',
                'numFound' => $res['response']['numFound']
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
     * @return string
     */
    private function setPorteur($fiche): string
    {
        if (isset($fiche->etablissement_porteur)) {
            $porteurData = json_decode($fiche->etablissement_porteur);

            return $porteurData->libelle;
        }

        return implode(', ', $fiche->etablissements_co_editeurs);
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
}