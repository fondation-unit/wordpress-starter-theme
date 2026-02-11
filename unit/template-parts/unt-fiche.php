<?php
$titreMentions = get_field('titre_mentions_concernees');
$mentions = get_field('mentions_concernees');
$actions = get_field('principales_actions');
?>
<div class="container">
    <div class="mentions my-md-6 my-4">
        <?php
        if ($titreMentions) {
            echo '<h2 class="no-point">' . $titreMentions . '</h2>';
        }
        ?>
        <?php
        the_field('mentions_concernees');
        ?>
    </div>
    <?php
    if ($actions):
        ?>
        <div class="actions">
            <h2>Principales actions</h2>
            <?php echo $actions; ?>
        </div>
    <?php
    endif;
    ?>
</div>
