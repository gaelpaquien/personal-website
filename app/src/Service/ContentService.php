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
    private const LOCALE_FR = 'fr';
    private const DATE_FORMAT_FR = 'd/m/Y';
    private const DATE_FORMAT_EN = 'm/d/Y';

    public function __construct(
        private ReviewRepository $reviewRepository,
        private ArticleRepository $articleRepository,
        private ProjectRepository $projectRepository,
    ) {}

    public function getAllProjects(string $locale): array
    {
        $projects = $this->projectRepository->findAllOrdered();

        return array_map(function($project) use ($locale) {
            return new Project(
                title: $project->getTitle($locale),
                description: $project->getArticle()->getShortDescription($locale),
                tags: $project->getArticle()->getTags($locale),
                coverImage: $project->getArticle()->getCoverMedia()->getMedia(),
                coverImageAltText: $project->getArticle()->getCoverMedia()->getAltText($locale),
                relatedArticleSlug: $project->getArticle()->getSlug($locale),
            );
        }, $projects);
    }

    public function getAllReviews(string $locale): array
    {
        $reviews = $this->reviewRepository->findAllOrderedActive();

        return array_map(function($review) use ($locale) {
            return new Review(
                authorFirstName: $review->getAuthorFirstname(),
                authorLastName: $review->getAuthorLastname()[0] . '.',
                authorJobTitle: $locale === self::LOCALE_FR ? $review->getAuthorJobFr() : $review->getAuthorJobEn(),
                authorCompany: $review->getAuthorCompany(),
                content: ucfirst($locale === self::LOCALE_FR ? $review->getContentFr() : $review->getContentEn()),
                source: $review->getSource(),
                createdAt: $review->getCreatedAt()->format($this->formatDate($review->getCreatedAt(), $locale)),
            );
        }, $reviews);
    }

    public function getAllArticles(string $locale): array
    {
        $articles = $this->articleRepository->findAllOrderedByDate();

        return array_map(function($article) use ($locale) {
            return new Article(
                title: $article->getTitle($locale),
                slug: $article->getSlug($locale),
                shortDescription: $article->getShortDescription($locale),
                content: $article->getContent($locale),
                tags: $article->getTags($locale),
                resourceLinks: $article->getResourceLinks($locale),
                updatedAt: $article->getUpdatedAt()->format($this->formatDate($article->getUpdatedAt(), $locale)),
                coverImage: $article->getCoverMedia()->getMedia(),
                coverImageAltText: $article->getCoverMedia()->getAltText($locale),
            );
        }, $articles);
    }

    /**
     * @throws RedirectArticleException
     */
    public function getArticleBySlug(string $slug, string $locale): Article
    {
        $article = $this->articleRepository->findBySlug($slug, $locale);

        if (!$article) {
            throw new NotFoundHttpException();
        }

        $correctSlug = $article->getSlug($locale);
        if ($slug !== $correctSlug) {
            throw new RedirectArticleException($correctSlug);
        }

        return new Article(
            $article->getTitle($locale),
            $article->getSlug($locale),
            $article->getShortDescription($locale),
            $article->getContent($locale),
            $article->getTags($locale),
            $article->getResourceLinks($locale),
            $article->getUpdatedAt()->format($this->formatDate($article->getUpdatedAt(), $locale)),
            $article->getCoverMedia()->getMedia(),
            $article->getCoverMedia()->getAltText($locale)
        );
    }

    private function formatDate(\DateTimeImmutable $date, string $locale): string
    {
        return $locale === self::LOCALE_FR ? $date->format(self::DATE_FORMAT_FR) : $date->format(self::DATE_FORMAT_EN);
    }
}