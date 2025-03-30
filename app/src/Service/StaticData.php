<?php

declare(strict_types=1);

namespace App\Service;

class StaticData
{
    public function getPortfolioProjects(): array
    {
        return [
            [
                'title' => 'Plany',
                'description' => 'Participation à la maintenance et au développement du logiciel SaaS Plany, ainsi qu\'à la conception de nouvelles applications web.',
                'image' => 'images/portfolio/portfolio-plany.webp',
                'tags' => ['PHP', 'Symfony', 'Laravel', 'MySQL', 'OpenSearch', 'Architecture Hexagonale', 'Livewire', 'Alpine.js', 'Vue.js', 'Tailwind CSS'],
                'order' => 1,
                'related_blog_post_slug' => 'developpeur-backend-chez-plany-logiciel-saas-dans-le-secteur-de-l-evenementiel'
            ],
            [
                'title' => 'gaelpaquien.com',
                'description' => 'Conception et développement de mon site personnel incluant un portfolio, un blog, un système d\'avis utilisateurs et un formulaire de contact.',
                'image' => 'images/portfolio/portfolio-personal-website.webp',
                'tags' => ['PHP', 'Symfony', 'MySQL', 'Docker', 'Stimulus', 'Saas'],
                'order' => 2,
                'related_blog_post_slug' => 'conception-et-developpement-de-mon-site-personnel-avec-php-et-symfony'
            ],
            [
                'title' => 'RG Clean Car',
                'description' => 'Conception d\'un site vitrine sous WordPress pour RG Clean Car, société spécialisée dans le nettoyage automobile à domicile, intégrant un formulaire de contact.',
                'image' => 'images/portfolio/portfolio-rgcleancar.webp',
                'tags' => ['WordPress'],
                'order' => 3,
                'related_blog_post_slug' => 'creation-du-site-vitrine-rgcleancar-avec-wordpress'
            ],
            [
                'title' => 'ToDo & Co',
                'description' => 'Audit qualité et performance d\'une application existante afin d\'identifier les axes d\'amélioration, puis optimisation du code et réduction de la dette technique.',
                'image' => 'images/portfolio/portfolio-todoandco.webp',
                'tags' => ['PHP', 'Symfony', 'MySQL', 'Docker', 'JavaScript', 'Bootstrap'],
                'order' => 4,
                'related_blog_post_slug' => 'audit-et-optimisation-de-todoandco-application-php-et-symfony'
            ],
            [
                'title' => 'BileMo API',
                'description' => 'Conception et développement d\'une API REST permettant aux clients authentifiés d\'accéder à une liste de produits et d\'utilisateurs.',
                'image' => 'images/portfolio/portfolio-bilemo-api.webp',
                'tags' => ['PHP', 'Symfony', 'MySQL', 'Docker'],
                'order' => 5,
                'related_blog_post_slug' => 'conception-et-developpement-de-bilemo-une-api-rest-avec-php-et-symfony'
            ],
            [
                'title' => 'SnowTricks',
                'description' => 'Conception et développement d\'un site communautaire permettant aux utilisateurs de partager et commenter des figures de snowboard.',
                'image' => 'images/portfolio/portfolio-snowtricks.webp',
                'tags' => ['PHP', 'Symfony', 'MySQL', 'Docker', 'JavaScript', 'Sass'],
                'order' => 6,
                'related_blog_post_slug' => 'conception-et-developpement-d-un-site-communautaire-de-snowboard-avec-php-et-symfony'
            ],
            [
                'title' => 'Blog PHP MVC',
                'description' => 'Découverte du langage PHP à travers la conception et le développement d\'un blog complet basé sur une architecture MVC.',
                'image' => 'images/portfolio/portfolio-blog-php-mvc.webp',
                'tags' => ['PHP', 'MySQL', 'JavaScript', 'MVC'],
                'order' => 7,
                'related_blog_post_slug' => 'decouverte-de-php-avec-la-creation-d-un-blog-et-une-architecture-mvc'
            ],
        ];
    }

    public function getReviews(): array
    {
        return [
            [
                'author' => 'Thomas Gérault',
                'author_job' => 'Mentor',
                'author_company' => 'OpenClassrooms',
                'content' => 'En reconversion professionnelle pour se spécialiser dans le développement web full stack, Gaël a suivi la formation d\'openclassrooms. Le point fort de Gaël est sa détermination : ne rien lâcher et aller toujours au bout des choses. Sérieux, appliqué et rigoureux, il a su monter en compétence rapidement et réussir ses projets avec brio.',
                'source' => 'LinkedIn',
                'created_at' => '28/06/2021',
                'order' => 1
            ],
            [
                'author' => 'Jérôme Gaviot',
                'author_job' => 'Cofondateur',
                'author_company' => 'RG Clean Car',
                'content' => 'Gaël a réalisé notre site web "www.rgcleancar.fr" exactement comme nous l\'avions souhaité, communication claire et professionnelle, je recommande !',
                'source' => 'gaelpaquien.com',
                'created_at' => '11/01/2024',
                'order' => 2
            ],
            [
                'author' => 'John Doe',
                'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                'source' => 'Google',
                'created_at' => '01/01/2024',
                'order' => 3
            ]
        ];
    }

    public function getBlogPosts(): array
    {
        return [
            [
                'title' => 'Développeur Backend chez Plany : logiciel SaaS dans le secteur de l\'événementiel',
                'slug' => 'developpeur-backend-chez-plany-logiciel-saas-dans-le-secteur-de-l-evenementiel',
                'content' => $this->getLoremIpsum(),
                'image' => 'images/blog/blog-plany.webp',
                'tags' => ['PHP', 'Symfony', 'Laravel', 'MySQL', 'OpenSearch', 'Architecture Hexagonale', 'Livewire', 'Alpine.js', 'Vue.js', 'Tailwind CSS'],
                'created_at' => '25/03/2025 19:00',
                'updated_at' => '25/03/2025 19:00',
            ],
            [
                'title' => 'Conception et développement de mon site personnel avec PHP et Symfony',
                'slug' => 'conception-et-developpement-de-mon-site-personnel-avec-php-et-symfony',
                'content' => $this->getLoremIpsum(),
                'image' => 'images/blog/blog-personal-website.webp',
                'tags' => ['PHP', 'Symfony', 'MySQL', 'Docker', 'Stimulus', 'Saas'],
                'created_at' => '25/03/2025 18:00',
                'updated_at' => '25/03/2025 18:00',
            ],
            [
                'title' => 'Création du site vitrine RG Clean Car avec WordPress',
                'slug' => 'creation-du-site-vitrine-rgcleancar-avec-wordpress',
                'content' => $this->getLoremIpsum(),
                'image' => 'images/blog/blog-rgcleancar.webp',
                'tags' => ['WordPress'],
                'created_at' => '25/03/2025 17:00',
                'updated_at' => '25/03/2025 17:00',
            ],
            [
                'title' => 'Audit et optimisation de ToDo&Co : application PHP et Symfony',
                'slug' => 'audit-et-optimisation-de-todoandco-application-php-et-symfony',
                'content' => $this->getLoremIpsum(),
                'image' => 'images/blog/blog-todoandco.webp',
                'tags' => ['PHP', 'Symfony', 'MySQL', 'Docker', 'JavaScript', 'Bootstrap'],
                'created_at' => '25/03/2025 16:00',
                'updated_at' => '25/03/2025 16:00',
            ],
            [
                'title' => 'Conception et développement de BileMo : une API REST avec PHP et Symfony',
                'slug' => 'conception-et-developpement-de-bilemo-une-api-rest-avec-php-et-symfony',
                'content' => $this->getLoremIpsum(),
                'image' => 'images/blog/blog-bilemo-api.webp',
                'tags' => ['PHP', 'Symfony', 'MySQL', 'Docker'],
                'created_at' => '25/03/2025 15:00',
                'updated_at' => '25/03/2025 15:00',
            ],
            [
                'title' => 'Conception et développement d\'un site communautaire de snowboard avec PHP et Symfony',
                'slug' => 'conception-et-developpement-d-un-site-communautaire-de-snowboard-avec-php-et-symfony',
                'content' => $this->getLoremIpsum(),
                'image' => 'images/blog/blog-snowtricks.webp',
                'tags' => ['PHP', 'Symfony', 'MySQL', 'Docker', 'JavaScript', 'Sass'],
                'created_at' => '25/03/2025 14:00',
                'updated_at' => '25/03/2025 14:00',
            ],
            [
                'title' => 'Découverte de PHP avec la création d\'un blog et une architecture MVC',
                'slug' => 'decouverte-de-php-avec-la-creation-d-un-blog-et-une-architecture-mvc',
                'content' => $this->getLoremIpsum(),
                'image' => 'images/blog/blog-blog-php-mvc.webp',
                'tags' => ['PHP', 'MySQL', 'JavaScript', 'MVC'],
                'created_at' => '25/03/2025 13:00',
                'updated_at' => '25/03/2025 13:00',
            ]
        ];
    }

    public function getBlogPostDetails(string $slug): ?array
    {
        $blogPosts = $this->getBlogPosts();

        foreach ($blogPosts as $post) {
            if ($post['slug'] === $slug) {
                return [
                    ...$post,

                    'links' => match($slug) {
                        'developpeur-backend-chez-plany-logiciel-saas-dans-le-secteur-de-l-evenementiel' => [
                            [
                                'title' => 'plany.jobs - Le site vitrine de Plany',
                                'url' => 'https://www.plany.jobs/'
                            ],
                            [
                                'title' => 'app.plany.jobs - L\'application déiée aux candidats en recherche d\'un emploi',
                                'url' => 'https://app.plany.jobs//'
                            ],
                            [
                                'title' => 'board.plany.app - La nouvelle version de la CVthèque Plany',
                                'url' => 'https://board.plany.app/'
                            ]
                        ],
                        'conception-et-developpement-de-mon-site-personnel-avec-php-et-symfony' => [
                            [
                                'title' => 'Repository GitHub',
                                'url' => 'https://github.com/gaelpaquien/personal-website'
                            ],
                            [
                                'title' => 'gaelpaquien.com',
                                'url' => 'https://localhost:8443/'
                            ]
                        ],
                        'creation-du-site-vitrine-rgcleancar-avec-wordpress' => [
                            [
                                'title' => 'Site RG Clean Car',
                                'url' => 'https://www.rgcleancar.fr'
                            ],
                        ],
                        'audit-et-optimisation-de-todoandco-application-php-et-symfony' => [
                            [
                                'title' => 'Repository GitHub',
                                'url' => 'https://github.com/gaelpaquien/openclassrooms-todoandco'
                            ],
                            [
                                'title' => 'ToDo & Co',
                                'url' => 'https://localhost:8443/'
                            ]
                        ],
                        'conception-et-developpement-de-bilemo-une-api-rest-avec-php-et-symfony' => [
                            [
                                'title' => 'Repository GitHub',
                                'url' => 'https://symfony.com/doc'
                            ],
                            [
                                'title' => 'BileMo API',
                                'url' => 'https://github.com/gaelpaquien/openclassrooms-bilemo/'
                            ]
                        ],
                        'conception-et-developpement-d-un-site-communautaire-de-snowboard-avec-php-et-symfony' => [
                            [
                                'title' => 'Repository GitHub',
                                'url' => 'https://github.com/gaelpaquien/openclassrooms-snowtricks'
                            ],
                            [
                                'title' => 'SnowTricks',
                                'url' => 'https://localhost:8443/'
                            ]
                        ],
                        'decouverte-de-php-avec-la-creation-d-un-blog-et-une-architecture-mvc' => [
                            [
                                'title' => 'Repository GitHub',
                                'url' => 'https://github.com/gaelpaquien/openclassrooms-blog-php'
                            ],
                            [
                                'title' => 'Blog PHP MVC',
                                'url' => 'https://localhost:8443/'
                            ]
                        ],
                        default => []
                    }
                ];
            }
        }

        return null;
    }

    private function getLoremIpsum(): string
    {
        return 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.';
    }
}