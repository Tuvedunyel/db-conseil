<?php get_header(); ?>
    <main class="front-page">
        <div id="root">
            <div class="display-none">
                <router-link to="/"></router-link>
                <router-link to="/poste/:reference"></router-link>
                <router-link to="/Resultats"></router-link>
            </div>
            <router-view v-slot="{ Component }">
                <transition name="component-fade" mode="out-in">
                    <component :is="Component" />
                </transition>
            </router-view>
        </div>
        <script type="text/x-template" id="home">
            <div v-if="!loading">
                <section class="hero-banner">
                    <div class="background-image"></div>
                    <div class="gradient">
                        <div class="container">
                            <h1>Et si on envisageait le recrutement autrement ?</h1>
                            <div class="job-container">
                                <h2>Je trouve mon poste</h2>
                                <form v-on:submit.prevent="onSubmit">
                                    <div class="select">
                                        <select v-model="searchCategorie" name="categorie" id="categorie" aria-label="Quelle catégorie de poste ?">
                                            <option value="">Catégorie</option>
                                            <option class="deroulant" v-for="categorie in filteredCategory" v-bind:value="categorie">{{categorie}}</option>
                                        </select>
                                    </div>
                                    <div class="select">
                                        <select v-model="searchRegion" name="region" id="region" aria-label="Dans quelle région recherchez-vous ?">
                                            <option value="">Région</option>
                                            <option class="deroulant" v-for="region in filteredRegion" v-bind:value="region">{{region}}</option>
                                        </select>
                                    </div>
                                    <input v-model="searchJobType" type="text" name="post-type" id="post-type"
                                           placeholder="Intitulé du poste" aria-label="Intitulé du poste" autocomplete="off">
                                    <router-link
                                            :to="{ name: 'Resultats', params: { searchCategorie, searchRegion, searchJobType }}"
                                            class="rechercher-job">Rechercher</router-link>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
                <section class="job">
                    <div class="container">
                        <h2>Nos poste à la une</h2>
                        <div class="card-container" v-if="!loading">
                            <div v-for='job in slicePost' class="card">
                                <strong>{{job.address_state}}</strong>
                                <div class="card-detail">
                                    <p class="categorie">{{industriesCategory(job.industry)}}</p>
                                    <h3>{{job.label}}</h3>
                                    <p v-if="job.description.length<208" v-html="job.description"></p>
                                    <p v-else v-html='job.description.substring(0, 208)+"..."'></p>
                                    <router-link v-if="job.reference" class="card-link" :to="{ name: 'Description', params: { job: JSON.stringify(job), reference: job.reference.replace(/\s/g, '') } }"><?php the_field('texte_bouton_en_savoir_plus'); ?>
                                    </router-link>
                                </div>
                            </div>
                        </div>
                        <a class="offres-link" href="<?php the_field('lien_toutes_offres'); ?>"><?php the_field('texte_toutes_offres'); ?></a>
                    </div>
                </section>
                <section class="cabinet">
                    <div class="container">
                        <aside class="<?php if (get_field('image_membre_deux')) : echo 'deuximage'; endif; ?>">
                            <div id="stephanie">
                                <?php $imageStephanie = get_field('image_membre_un'); ?>
                                <img src="<?php echo esc_url($imageStephanie['url']); ?>" alt="<?php echo esc_attr($imageStephanie['alt']); ?>">
                                <div class="link-container">
                                    <a class="<?php if (get_field('image_membre_deux')) : echo 'margintop'; endif; ?>" rel="noopener noreferrer" href="<?php the_field('lien_linkedin_membre_un'); ?>"><?php the_field('nom_membre_un'); ?></a>
                                    <?php if(!get_field('image_membre_deux')): ?>
                                        <a rel="noopener noreferrer" href="<?php the_field('lien_linkedin_membre_deux'); ?>"><?php the_field('nom_membre_deux'); ?></a>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php if (get_field('image_membre_deux')) : ?>
                                <div id="pauline">
                                    <?php $imagePauline = get_field('image_membre_deux'); ?>
                                    <img src="<?php echo esc_url($imagePauline['url']); ?>" alt="<?php echo esc_attr($imagePauline['alt']); ?>">
                                    <a class="<?php if (get_field('image_membre_deux')) : echo 'margintop'; endif; ?>" rel="noopener noreferrer" href="<?php the_field('lien_linkedin_membre_deux'); ?>"><?php the_field('nom_membre_deux'); ?></a>
                                </div>
                            <?php endif; ?>
                        </aside>
                        <article>
                            <h2><?php the_field('titre_cabinet_principal'); ?></h2>
                            <?php the_field('texte_cabinet'); ?>
                            <a rel="noopener noreferrer" href="<?php the_field('lien_page_cabinet'); ?>"><?php the_field('texte_lien_page_cabinet'); ?></a>
                        </article>
                    </div>
                    <span class="telescope"></span>
                </section>
                <section class="post-recruit">
                    <div class="postule">
                        <h2><?php the_field('titre_fond_bleu'); ?></h2>
                        <div class="texte-fond">
                            <?php the_field('texte_fond_bleu'); ?>
                        </div>
                        <a rel="noopener noreferrer" href="<?php the_field('lien_fond_bleu'); ?>"><?php the_field('texte_lien_fond_bleu'); ?></a>
                    </div>
                    <div class="recrute">
                        <h2><?php the_field('titre_fond_blanc'); ?></h2>
                        <div class="texte-fond">
                            <?php the_field('texte_fond_blanc'); ?>
                        </div>
                        <a rel="noopener noreferrer" href="<?php the_field('lien_fond_blanc'); ?>"><?php the_field('texte_lien_fond_blanc'); ?></a>
                    </div>
                </section>
                <section class="temoignages">
                    <div class="container">
                        <div class="title-container">
                            <h2><?php the_field('titre_temoignages'); ?></h2>
                        </div>
                        <?php if ( have_rows('temoignages') ) : ?>
                            <div class="splide">
                                <div class="splide__track">
                                    <ul class="splide__list">
                                        <?php while ( have_rows('temoignages') ) : the_row(); ?>
                                            <li class="splide__slide">
                                                <div class="temoignages-container">
                                                    <?php $imagePremierTemoin = get_sub_field('photo_premier_temoignage'); ?>
                                                    <div class="slider-image__container">
                                                        <img src="<?php echo esc_url($imagePremierTemoin['url']); ?>" alt="<?php echo esc_attr($imagePremierTemoin['alt']); ?>">
                                                    </div>
                                                    <article>
                                                        <p><?php the_sub_field('texte_premier_temoignage'); ?></p>
                                                        <strong><?php the_sub_field('nom_et_profession_premier_temoignage'); ?></strong>
                                                    </article>
                                                </div>
                                                <div class="temoignages-container">
                                                    <?php $imageDeuxiemeTemoin = get_sub_field('photo_deuxieme_temoignage'); ?>
                                                    <div class="slider-image__container">
                                                        <img src="<?php echo esc_url($imageDeuxiemeTemoin['url']) ?>" alt="<?php echo esc_attr($imageDeuxiemeTemoin['alt']); ?>">
                                                    </div>
                                                    <article>
                                                        <p><?php the_sub_field('texte_deuxieme_temoignage'); ?></p>
                                                        <strong><?php the_sub_field('nom_et_profession_deuxieme_temoignage'); ?></strong>
                                                    </article>
                                                </div>
                                            </li>
                                        <?php endwhile; ?>
                                    </ul>
                                </div>
                            </div>
                        <?php else : ?>
                            <h3 class="avenir">à venir</h3>
                        <?php endif; ?>
                    </div>
                </section>
            </div>
        </script>

        <?php get_template_part('layout/description-front'); ?>
        <?php get_template_part('layout/resultats'); ?>
    </main>
<?php get_footer(); ?>