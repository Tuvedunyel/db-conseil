<?php

/*

Template Name: Je postule

*/


?>

<?php get_header(); ?>

<main class="postule-recrute">
    <section id="start-decription" class="hero-banner">
        <div class="container">
            <h1><?php the_title(); ?></h1>
        </div>
    </section>
    <div id="root">
        <div class="display-none">
            <router-link to="/je-postule">
                <p>Home</p>
            </router-link>
            <router-link to="/Resultats">
                <p>Rechercher</p>
            </router-link>
            <router-link to="/Description">
                <p>Description</p>
            </router-link>
        </div>

        <router-view v-slot="{ Component }">
            <transition name="component-fade" mode="out-in">
                <component :is="Component" />
            </transition>
        </router-view>
    </div>



    <script type="text/x-template" id="postule">
    <div v-if="!loading">

        <section class="job">
            <div class="container">
                <h2><?php the_field('titre_carte'); ?></h2>
                <div class="card-container">
                    <div v-for='job in slicePost' class="card">
                        <strong>{{job.address_state}}</strong>
                        <div class="card-detail">
                            <p class="categorie">{{industriesCategory(job.industry)}}</p>
                            <h3>{{job.label}}</h3>
                            <p v-if="job.description.length<208" v-html="job.description"></p>
                            <p v-else v-html="job.description.substring(0, 208) + '...'"></p>
                            <router-link class="card-link" v-if="job.reference" :to="{ name: 'Description', params: { job: JSON.stringify(job), reference: job.reference.replace(/\s/g, '') } }">En savoir plus</router-link>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="postuler-job">
            <div class="container">
                <h2><?php the_field('titre_envoi_candidature'); ?></h2>
                <?php get_template_part('layout/contact-form-poste'); ?>
            </div>
        </section>
        <section class="bottom-part">
            <div class="container">
                <h2><?php the_field('titre_bottom') ?></h2>
                <i><?php the_field('texte_bottom') ?></i>
                <div class="article-bottom">
                    <aside>
                        <?php $image = get_field('image'); ?>
                        <img src="<?php echo esc_url($image['url']) ?>" alt="<?php echo esc_attr($image['alt']); ?>">
                    </aside>
                    <article>
                        <?php if( have_rows('nos_qualites') ) : ?>
                            <?php while( have_rows('nos_qualites') ) : the_row(); ?>
                                <div class="texte-card">
                                    <h3><?php the_sub_field('titre'); ?></h3>
                                    <p><?php the_sub_field('texte'); ?></p>
                                </div>
                            <?php endwhile; ?>
                        <?php endif; ?>
                        <div class="lien-container">
                            <a rel="noopener noreferrer" href="<?php the_field('lien_bottom') ?>"><?php the_field('texte_lien') ?></a>
                            <p><?php the_field('texte_post_lien'); ?></p>
                        </div>
                    </article>
                </div>
            </div>
        </section>
    </div>
    </script>
        <?php get_template_part('layout/description-postule'); ?>
    </main>
    
    <?php get_footer(); ?>