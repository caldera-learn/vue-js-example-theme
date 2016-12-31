<?php

get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">
        <div id="app">
            <post></post>
        </div>

        <script type="text/html" id="post-tmpl">
            <div id="post">
                <article v-bind:id="'post-' + post.id">
                    <header>
                        <h2 class="post-title">
                            {{post.title.rendered}}
                        </h2>
                    </header>
                    <div class="entry-content" v-html="post.content.rendered"></div>
                </article>
            </div>
        </script>

        <?php
        $post_type = get_post_type_object( get_post_type( ) );
       ?>
        <script>
            (function($){
                var config = {
                    api: {
                        posts: "<?php echo esc_url_raw( rest_url( 'wp/v2/' . $post_type->rest_base . '/' ) ); ?>"
                    },
                    nonce: "<?php echo wp_create_nonce( 'wp_rest' ); ?>"
                };

                var vue;
                $.when( $.get( config.api.posts + '1' ) ).then( function( d ){
                    var post = Vue.component( 'post', {
                        template: '#post-tmpl',
                        data: function(){
                            return {
                                post: d
                            }
                        }
                    });

                    vue = new Vue({
                        el: '#app',
                        data: {}

                    });
                });
            })( jQuery );

        </script>

    </main><!-- .site-main -->
</div><!-- .content-area -->

<?php get_footer(); ?>
