<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Pager extends BaseConfig
{
    public $pagerConfig = [
        'templates' => [
            'default_full' => '
                <div class="mt-4">
                    <nav aria-label="navigation">
                        <ul class="pagination pagination-light d-inline-block d-md-flex justify-content-center">
                            {first}
                            {prev_link}
                            {links}
                            {next_link}
                            {last}
                        </ul>
                    </nav>
                </div>',
            'first' => '<li class="page-item"><a href="{uri}" class="page-link">First</a></li>',
            'prev_link' => '<li class="page-item"><a href="{uri}" class="page-link">Prev</a></li>',
            'next_link' => '<li class="page-item"><a href="{uri}" class="page-link">Next</a></li>',
            'last' => '<li class="page-item"><a href="{uri}" class="page-link">Last</a></li>',
            'link' => '<li {active}><a href="{uri}" class="page-link">{title}</a></li>',
            'active_link' => '<li class="page-item active"><a href="{uri}" class="page-link">{title}</a></li>',
            'disabled_link' => '<li class="page-item disabled"><a href="#" class="page-link">{title}</a></li>'
        ]
    ];
    /**
     * --------------------------------------------------------------------------
     * Templates
     * --------------------------------------------------------------------------
     *
     * Pagination links are rendered out using views to configure their
     * appearance. This array contains aliases and the view names to
     * use when rendering the links.
     *
     * Within each view, the Pager object will be available as $pager,
     * and the desired group as $pagerGroup;
     *
     * @var array<string, string>
     */
     public array $templates = [
        'default_full'   => 'CodeIgniter\Pager\Views\default_full',
        'default_simple' => 'CodeIgniter\Pager\Views\default_simple',
        'default_head'   => 'CodeIgniter\Pager\Views\default_head',
        'socio_custom_pagination' => 'App\Views\Pagers\socio_custom_pagination'
    ];

    /**
     * --------------------------------------------------------------------------
     * Items Per Page
     * --------------------------------------------------------------------------
     *
     * The default number of results shown in a single page.
     */
    public int $perPage = 20;
}
