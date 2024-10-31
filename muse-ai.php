<?php
/**
 * Plugin Name: muse.ai
 * Description: Enable oEmbed and shortcode support for muse.ai video embedding.
 * Version: 0.4
 * Author: muse.ai
 * Author URI: https://muse.ai
 */

add_action('init', 'museai_init');
add_action('elementor/widgets/register', 'museai_elementor');
add_shortcode('muse-ai', 'museai_shortcode_video');

function museai_init() {
    wp_oembed_add_provider('#https://muse.ai/(v|vc|vd|vt)/.+#', 'https://muse.ai/oembed', true);
    wp_enqueue_script('museai-embed-player', 'https://muse.ai/static/js/embed-player.min.js');
}

function museai_shortcode_video( $atts = [] ) {
    $embed_id = bin2hex(random_bytes(16));
    $video_id = preg_replace('/[^a-z0-9]/i', '', $atts['id'] ?? '');
    $width = preg_replace('/[^0-9%]/', '', $atts['width'] ?? '100%');
    $volume = (int) preg_replace('/[^0-9]/', '', $atts['volume'] ?? '50');
    $autoplay = (int) preg_replace('/[^01]/', '', $atts['autoplay'] ?? '0');
    $title = (int) preg_replace('/[^01]/', '', $atts['title'] ?? '1');
    $style = preg_replace('/"/', '', $atts['style'] ?? 'full');
    $start = (float) preg_replace('/[^0-9.]/', '', $atts['start'] ?? '0');
    $loop = (int) preg_replace('/[^01]/', '', $atts['loop'] ?? '0');
    $resume = (int) preg_replace('/[^01]/', '', $atts['resume'] ?? '0');
    $align = preg_replace('/"/', '', $atts['align'] ?? '');
    $playpos = preg_replace('/"/', '', $atts['cover_play_position'] ?? 'bottom-left');
    $cta = addslashes(($atts['cta'] ?? '') ? $atts['cta'] : '');
    $css = preg_replace('/"/', '\'', $atts['css'] ?? '');
    $subtitles = preg_replace('/"/', '', $atts['subtitles'] ?? '');
    $locale = preg_replace('/"/', '', $atts['locale'] ?? '');
    $download = (int) preg_replace('/[^01]/', '', $atts['download'] ?? '0');
    $playlist = preg_replace('/[^a-z0-9,]/i', '', $atts['playlist'] ?? '');

    $links = preg_replace('/"/', '', $atts['links'] ?? '1');
    $links = $links == '0' || $links == '1' ? (int) $links : sprintf('"%s"', $links);

    $logo = preg_replace('/"/', '', $atts['logo'] ?? '1');
    $logo = $logo == '0' || $logo == '1' ? (int) $logo : sprintf('"%s"', $logo);

    $search = preg_replace('/"/', '', $atts['search'] ?? '1');
    $search = $search == '0' || $search == '1' ? (int) $search : sprintf('"%s"', $search);

    $out = sprintf(
        '<div id="museai-player-%s"></div>'.
        '<script>'.
        'MusePlayer({'.
        'container: "#museai-player-%1$s", video: "%s", '.
        'width: "%s", links: %s, logo: %s, search: %s, autoplay: %s, '.
        'volume: %s, title: %s, style: "%s", start: %s, loop: %s, '.
        'resume: %s, align: "%s", coverPlayPosition: "%s", cta: "%s", '.
        'css: "%s", subtitles: "%s", locale: "%s", download: %s, '.
        'playlist: "%s"'.
        '})'.
        '</script>',
        $embed_id,
        $video_id,
        $width,
        $links,
        $logo,
        $search,
        $autoplay,
        $volume,
        $title,
        $style,
        $start,
        $loop,
        $resume,
        $align,
        $playpos,
        $cta,
        $css,
        $subtitles,
        $locale,
        $download,
        $playlist
    );
    return $out;
}

function museai_elementor( $widgets_manager ) {
    class Elementor_Museai_Widget extends \Elementor\Widget_Base {
        public function get_name() {
            return 'muse.ai';
        }
        public function get_title() {
            return esc_html__( 'muse.ai', 'elementor-oembed-widget' );
        }
        public function get_icon() {
            return 'eicon-youtube';
        }
        public function get_custom_help_url() {
            return 'https://wordpress.org/plugins/muse-ai/';
        }
        public function get_categories() {
            return [ 'general' ];
        }
        public function get_keywords() {
            return [ 'embed', 'url', 'link', 'video' ];
        }
        protected function register_controls() {
            $this->start_controls_section(
                'content_section',
                [
                    'label' => esc_html__( 'Content', 'elementor-museai-widget' ),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
            );
            $this->add_control(
                'video_id',
                [
                    'label' => esc_html__( 'Video ID', 'elementor-museai-widget' ),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'input_type' => 'text',
                    'placeholder' => esc_html__( 'A1b2C3d', 'elementor-oembed-widget' ),
                ]
            );
            $this->add_control(
                'title',
                [
                    'label' => esc_html__( 'Title', 'elementor-museai-widget' ),
                    'type' => \Elementor\Controls_Manager::SWITCHER,
                    'label_on' => 'show',
                    'label_off' => 'hide',
                    'default' => 'yes',
                ]
            );
            $this->add_control(
                'logo',
                [
                    'label' => esc_html__( 'Logo', 'elementor-museai-widget' ),
                    'type' => \Elementor\Controls_Manager::SWITCHER,
                    'label_on' => 'show',
                    'label_off' => 'hide',
                    'default' => 'yes',
                ]
            );
            $this->add_control(
                'links',
                [
                    'label' => esc_html__( 'Link to video page', 'elementor-museai-widget' ),
                    'type' => \Elementor\Controls_Manager::SWITCHER,
                    'label_on' => 'yes',
                    'label_off' => 'no',
                    'default' => 'yes',
                ]
            );
            $this->add_control(
                'search',
                [
                    'label' => esc_html__( 'Search', 'elementor-museai-widget' ),
                    'type' => \Elementor\Controls_Manager::SWITCHER,
                    'label_on' => 'show',
                    'label_off' => 'hide',
                    'default' => 'yes',
                ]
            );
            $this->add_control(
                'autoplay',
                [
                    'label' => esc_html__( 'Autoplay', 'elementor-museai-widget' ),
                    'type' => \Elementor\Controls_Manager::SWITCHER,
                    'label_on' => 'yes',
                    'label_off' => 'no',
                    'default' => 'no',
                ]
            );
            $this->add_control(
                'mute',
                [
                    'label' => esc_html__( 'Mute', 'elementor-museai-widget' ),
                    'type' => \Elementor\Controls_Manager::SWITCHER,
                    'label_on' => 'yes',
                    'label_off' => 'no',
                    'default' => 'no',
                ]
            );
            $this->end_controls_section();
        }
        protected function render() {
            $settings = $this->get_settings_for_display();
            $embed_id = bin2hex(random_bytes(16));
            $html = wp_oembed_get( $settings['video_id'] );

            $video_id = $settings['video_id'];
            $links = $settings['links'] == 'yes' ? 'true' : 'false';
            $logo = $settings['logo'] == 'yes' ? '1' : '0';
            $search = $settings['search'] == 'yes' ? '1' : '0';
            $title = $settings['title'] == 'yes' ? '1' : '0';
            $autoplay = $settings['autoplay'] == 'yes' ? '1' : '0';
            $volume = $settings['mute'] == 'yes' ? '0' : '100';

            $out = sprintf(
                '<div id="museai-player-%s"></div>'.
                '<script>'.
                'MusePlayer({'.
                'container: "#museai-player-%1$s", video: "%s", '.
                'links: %s, logo: %s, search: %s, autoplay: %s, volume: %s, title: %s'.
                '})'.
                '</script>',
                $embed_id,
                $video_id,
                $links,
                $logo,
                $search,
                $autoplay,
                $volume,
                $title,
            );
            echo $out;
        }
    }

    $widgets_manager->register( new Elementor_Museai_Widget() );
}
