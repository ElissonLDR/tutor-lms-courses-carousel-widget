<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Text_Shadow;

if ( ! defined( 'ABSPATH' ) ) exit;

class Maskavo_Courses_Widget extends Widget_Base {

    public function get_name() { return 'maskavo_courses'; }
    public function get_title() { return 'Cursos Maskavo'; }
    public function get_icon() { return 'eicon-slider-push'; }
    public function get_categories() { return ['tutor-lms']; }

    public function get_style_depends() { return ['swiper-css', 'maskavo-courses-style']; }
    public function get_script_depends() { return ['swiper-js', 'maskavo-courses-js']; }

    protected function register_controls() {

        /* 🔹 FILTRO */
        $this->start_controls_section('maskavo_filtro', [
            'label' => 'Filtro',
            'tab'   => Controls_Manager::TAB_CONTENT,
        ]);

        $cat_options = [
            'all' => 'Todos'
        ];

        $terms = get_terms([
            'taxonomy' => 'course-category',
            'hide_empty' => false
        ]);

        foreach ($terms as $t) {
            $cat_options[$t->slug] = $t->name;
        }

        $this->add_control('categoria', [
            'label' => 'Categoria',
            'type' => Controls_Manager::SELECT,
            'options' => $cat_options,
            'default' => 'all'
        ]);

        $this->add_control('ordem', [
            'label' => 'Ordem',
            'type'  => Controls_Manager::SELECT,
            'options' => ['DESC'=>'Mais recentes','ASC'=>'Mais antigos'],
            'default' => 'DESC'
        ]);

        $this->end_controls_section();

        /* 🔹 SLIDES */
        $this->start_controls_section('maskavo_slides', [
            'label' => 'Slides',
            'tab'   => Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control('quantidade', [
            'label' => 'Quantidade de cursos',
            'type'  => Controls_Manager::NUMBER,
            'default' => 8,
        ]);
        $this->add_control('slides_desktop', [
            'label' => 'Slides (desktop)',
            'type'  => Controls_Manager::NUMBER,
            'default' => 4,
        ]);
        $this->add_control('slides_tablet', [
            'label' => 'Slides (tablet)',
            'type'  => Controls_Manager::NUMBER,
            'default' => 2,
        ]);
        $this->add_control('slides_mobile', [
            'label' => 'Slides (mobile)',
            'type'  => Controls_Manager::NUMBER,
            'default' => 1,
        ]);
        $this->add_control('loop', [
            'label' => 'Loop infinito',
            'type'  => Controls_Manager::SWITCHER,
            'default' => 'yes',
        ]);
        $this->add_control('autoplay', [
            'label' => 'Reprodução automática',
            'type'  => Controls_Manager::SWITCHER,
            'default' => 'yes',
        ]);
        $this->end_controls_section();

        /* 🔹 ELEMENTOS DO CARD */
        $this->start_controls_section('maskavo_elementos', [
            'label' => 'Elementos do Card',
            'tab'   => Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control('title_mode', [
            'label' => 'Posição do título',
            'type'  => Controls_Manager::SELECT,
            'options' => [
                'below' => 'Abaixo da imagem',
                'over'  => 'Sobre a imagem (inferior)',
            ],
            'default' => 'below',
        ]);

        $this->add_control('mostrar_titulo', [
            'label' => 'Mostrar título',
            'type'  => Controls_Manager::SWITCHER,
            'default' => 'yes'
        ]);

        $this->add_control('mostrar_botao', [
            'label' => 'Mostrar botão',
            'type'  => Controls_Manager::SWITCHER,
            'default' => 'yes',
            'condition' => ['title_mode' => 'below'],
        ]);
        $this->end_controls_section();

        /* 🔹 NAVEGAÇÃO */
        $this->start_controls_section('maskavo_nav', [
            'label' => 'Navegação',
            'tab'   => Controls_Manager::TAB_CONTENT,
        ]);
        $this->add_control('mostrar_setas', ['label'=>'Mostrar setas','type'=>Controls_Manager::SWITCHER,'default'=>'yes']);
        $this->add_control('mostrar_pontos',['label'=>'Mostrar pontos','type'=>Controls_Manager::SWITCHER,'default'=>'yes']);
        $this->end_controls_section();

        /* 🎨 LAYOUT */
        $this->start_controls_section('maskavo_layout', [
            'label' => 'Layout do Carrossel',
            'tab'   => Controls_Manager::TAB_STYLE,
        ]);
        $this->add_control('gap', [
            'label' => 'Espaçamento entre cards (px)',
            'type'  => Controls_Manager::SLIDER,
            'range' => ['px'=>['min'=>0,'max'=>80]],
            'default' => ['size'=>20],
        ]);
        $this->end_controls_section();

        /* 🎨 CARD */
        $this->start_controls_section('maskavo_style_card', [
            'label' => 'Card',
            'tab'   => Controls_Manager::TAB_STYLE,
        ]);
        $this->add_control('card_bg', [
            'label' => 'Cor de fundo',
            'type'  => Controls_Manager::COLOR,
            'selectors' => ['{{WRAPPER}} .maskavo-card' => 'background-color: {{VALUE}};'],
            'default' => '#fff',
        ]);
        $this->add_control('card_padding', [
            'label' => 'Padding interno',
            'type'  => Controls_Manager::DIMENSIONS,
            'selectors' => ['{{WRAPPER}} .maskavo-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'],
        ]);
        $this->add_control('card_radius', [
            'label' => 'Arredondamento',
            'type'  => Controls_Manager::SLIDER,
            'selectors' => [
                '{{WRAPPER}} .maskavo-card' => 'border-radius: {{SIZE}}px;',
                '{{WRAPPER}} .maskavo-thumb, {{WRAPPER}} .maskavo-thumb-img' => 'border-radius: {{SIZE}}px;'
            ],
        ]);
        $this->add_group_control(Group_Control_Box_Shadow::get_type(), ['name'=>'card_shadow','selector'=>'{{WRAPPER}} .maskavo-card']);
        $this->add_control('card_hover_scale', ['label'=>'Scale no hover','type'=>Controls_Manager::SWITCHER,'default'=>'yes']);
        $this->add_group_control(Group_Control_Box_Shadow::get_type(), ['name'=>'card_hover_shadow','selector'=>'{{WRAPPER}} .maskavo-card:hover']);
        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();

        $args = [
            'post_type' => 'courses',
            'posts_per_page' => $s['quantidade'],
            'order' => $s['ordem'],
        ];

        if (!empty($s['categoria']) && $s['categoria'] !== 'all') {
            $args['tax_query'] = [[
                'taxonomy'=>'course-category',
                'field'=>'slug',
                'terms'=>$s['categoria']
            ]];
        }

        $q = new WP_Query($args);

        if ($q->have_posts()) {

            $gap = isset($s['gap']['size']) ? (int)$s['gap']['size'] : 20;

            echo '<div class="maskavo-swiper swiper"
                data-desktop="'.$s['slides_desktop'].'"
                data-tablet="'.$s['slides_tablet'].'"
                data-mobile="'.$s['slides_mobile'].'"
                data-gap="'.$gap.'"
                data-loop="'.$s['loop'].'"
                data-autoplay="'.$s['autoplay'].'">';

            echo '<div class="swiper-wrapper">';

            while ($q->have_posts()) {
                $q->the_post();
                $link = get_permalink();

                echo '<div class="swiper-slide"><div class="maskavo-card">';

                if (has_post_thumbnail()) {
                    echo '<a href="'.$link.'" class="maskavo-thumb">';
                    the_post_thumbnail('medium',['class'=>'maskavo-thumb-img']);
                    echo '</a>';
                }

                if ($s['mostrar_titulo'] === 'yes') {
                    echo '<h4 class="maskavo-titulo">'.get_the_title().'</h4>';
                }

                if ($s['mostrar_botao'] === 'yes' && $s['title_mode'] === 'below') {
                    echo '<a href="'.$link.'" class="maskavo-botao">Matricular-se no curso</a>';
                }

                echo '</div></div>';
            }

            echo '</div>';

            if ($s['mostrar_setas'] === 'yes') {
                echo '<div class="swiper-button-prev"></div><div class="swiper-button-next"></div>';
            }

            if ($s['mostrar_pontos'] === 'yes') {
                echo '<div class="swiper-pagination"></div>';
            }

            echo '</div>';
        }

        wp_reset_postdata();
    }
}
