<?php

declare(strict_types=1);

namespace App\Service;

use App\DataTransferObjects\Article;
use App\DataTransferObjects\Project;
use App\DataTransferObjects\Review;
use App\Exception\RedirectArticleException;
use App\Repository\ArticleRepository;
use App\Repository\ProjectRepository;
use App\Repository\ReviewRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

readonly class ContentService
{
    private const DATE_FORMAT = 'd/m/Y';

    public function __construct(
        private ReviewRepository $reviewRepository,
        private ArticleRepository $articleRepository,
        private ProjectRepository $projectRepository,
    ) {}

    public function getAllProjects(): array
    {
        $projects = $this->projectRepository->findAllOrdered();

        return array_map(function($project) {
            return new Project(
                title: $project->getTitle(),
                description: $project->getArticle()->getShortDescription(),
                tags: $project->getArticle()->getTags(),
                coverImage: $project->getArticle()->getCoverMedia()->getMedia(),
                coverImageAltText: $project->getArticle()->getCoverMedia()->getAltText(),
                relatedArticleSlug: $project->getArticle()->getSlug(),
            );
        }, $projects);
    }

    public function getAllReviews(): array
    {
        $reviews = $this->reviewRepository->findAllOrderedActive();

        return array_map(function($review) {
            return new Review(
                authorFirstName: $review->getAuthorFirstname(),
                authorLastName: $review->getAuthorLastname()[0] . '.',
                authorJobTitle: $review->getAuthorJob(),
                authorCompany: $review->getAuthorCompany(),
                content: ucfirst($review->getContent()),
                source: $review->getSource(),
                createdAt: $review->getCreatedAt()->format(self::DATE_FORMAT),
            );
        }, $reviews);
    }

    public function getAllArticles(): array
    {
        $articles = $this->articleRepository->findAllOrderedByDate();

        return array_map(function($article) {
            return new Article(
                title: $article->getTitle(),
                slug: $article->getSlug(),
                shortDescription: $article->getShortDescription(),
                content: $article->getContent(),
                tags: $article->getTags(),
                resourceLinks: $article->getResourceLinks(),
                updatedAt: $article->getUpdatedAt()->format(self::DATE_FORMAT),
                coverImage: $article->getCoverMedia()->getMedia(),
                coverImageAltText: $article->getCoverMedia()->getAltText(),
            );
        }, $articles);
    }

    /**
     * @throws RedirectArticleException
     */
    public function getArticleBySlug(string $slug): Article
    {
        $article = $this->articleRepository->findBySlug($slug);

        if (!$article) {
            throw new NotFoundHttpException();
        }

        $correctSlug = $article->getSlug();
        if ($slug !== $correctSlug) {
            throw new RedirectArticleException($correctSlug);
        }

        return new Article(
            $article->getTitle(),
            $article->getSlug(),
            $article->getShortDescription(),
            $article->getContent(),
            $article->getTags(),
            $article->getResourceLinks(),
            $article->getUpdatedAt()->format(self::DATE_FORMAT),
            $article->getCoverMedia()->getMedia(),
            $article->getCoverMedia()->getAltText()
        );
    }
}
