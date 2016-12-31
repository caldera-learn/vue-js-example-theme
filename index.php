<?php


get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
            <div id="app">
                <post-list></post-list>
            </div>

            <script type="text/html" id="post-list-tmpl">
                <div id="posts">
                    <div v-for="post in posts">
                        <article v-bind:id="'post-' + post.id">
                            <header>
                                <h2 class="post-title">
                                    {{post.title.rendered}}
                                </h2>
                            </header>
                            <div class="entry-content" v-html="post.excerpt.rendered" v-if="list"></div>
                            <div class="entry-content" v-html="post.content.rendered" v-if="post.id == show"></div>
                            <a href="#" class="close" role="button" v-on:click.stop="close" v-if="post.id == show">Close</a>

                            <a href="#" class="read-more" role="button" v-on:click.stop="read(post.id)" v-if="list">Read More</a>
                        </article>
                    </div>
                </div>
            </script>



            <script>
                (function($){
                    var config = {
                        api: {
                            posts: "<?php echo esc_url_raw( rest_url( 'wp/v2/posts/' ) ); ?>"
                        },
                        nonce: "<?php echo wp_create_nonce( 'wp_rest' ); ?>"
                    };

                    var vue;
                    $.when( $.get( config.api.posts + '1' ) ).then( function( d ){
                        var posts = Vue.component('post-list', {
                            template: '#post-list-tmpl',
                            data: function () {
                                return {
                                    list: true,
                                    show: 0,
                                    posts: d
                                }
                            },
                            methods: {
                                read: function( id ){
                                    this.list = false;
                                    this.show = id;

                                },
                                close: function(){
                                    this.list = true;
                                    this.show = 0;
                                }
                            }
                        });

                        var post = Vue.component( 'post', {
                           template: '#post-tmpl',
                            props: function(){
                               return {
                                   post: Object
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
