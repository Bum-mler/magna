<?php
declare(strict_types=1);

namespace Simplesigns\MlStonelexicon\ViewHelpers;

// packages/ml_stonelexicon/Classes/ViewHelpers/PaginationViewHelper.php

use TYPO3\CMS\Extbase\Mvc\Web\Routing\UriBuilder;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\TagBuilder;

class PaginationViewHelper extends AbstractViewHelper
{
    /**
     * Render the pagination links.
     *
     * @return string Rendered pagination links.
     */
    public function render(): string
    {
        $currentPage = $this->arguments['currentPage'];
        $totalPages = $this->arguments['totalPages'];
        $itemsPerPage = $this->arguments['itemsPerPage'];
        $totalStones = $this->arguments['totalStones'];
        $action = $this->arguments['action'] ?? 'list';
        $controller = $this->arguments['controller'] ?? 'Stone';
        $additionalParams = $this->arguments['additionalParams'] ?? [];

        // Nur weiter und zurück anzeigen, wenn totalStones > itemsPerPage
        if ($totalStones <= $itemsPerPage) {
            return '';
        }

        $paginationLinks = '<ul class="pagination justify-content-center">';

        // zurück page link
        if ($currentPage > 1) {
            $paginationLinks .= '<li class="page-item">';
            $paginationLinks .= $this->createLink($currentPage - 1, $action, $controller, $additionalParams, '&laquo; zurück');
            $paginationLinks .= '</li>';
        }

        // weiter page link
        if ($currentPage < $totalPages) {
            $paginationLinks .= '<li class="page-item">';
            $paginationLinks .= $this->createLink($currentPage + 1, $action, $controller, $additionalParams, 'weiter &raquo;');
            $paginationLinks .= '</li>';
        }

        $paginationLinks .= '</ul>';

        return $paginationLinks;
    }

    /**
     * Helper method to create a link.
     *
     * @param int $page
     * @param string $action
     * @param string|null $controller
     * @param array $additionalParams
     * @param string $linkText
     * @return string
     */
    protected function createLink(int $page, string $action, ?string $controller, array $additionalParams, string $linkText): string
    {
        // Holen Sie den UriBuilder direkt aus dem RenderingContext
        /** @var UriBuilder $uriBuilder */
        $uriBuilder = GeneralUtility::makeInstance(UriBuilder::class);
        $request = $this->renderingContext->getRequest(); // Request-Objekt aus dem RenderingContext holen
        $uriBuilder->setRequest($request); // Request für den UriBuilder setzen
    
        // Entferne leere Parameter aus additionalParams
        $additionalParams = array_filter($additionalParams, function ($value) {
            return !empty($value);
        });
    
        // Füge den `searchColor`-Parameter hinzu, falls er gesetzt ist
        $searchColor = $this->arguments['additionalParams']['searchColor'] ?? $request->getQueryParams()['tx_mlstonelexicon_lexicon']['searchColor'] ?? '';
        if (!empty($searchColor)) {
            $additionalParams['tx_mlstonelexicon_lexicon']['searchColor'] = $searchColor;
        }
    
        $queryParams = array_merge($additionalParams, [
            'tx_mlstonelexicon_lexicon' => [
                'controller' => $controller,
                'action' => $action,
                'page' => $page,
                'searchOrigin' => $additionalParams['searchOrigin'] ?? '', // Übergebe den Filterwert
                'searchColor' => $additionalParams['searchColor'] ?? '',  // Übergebe auch andere Filter, falls vorhanden
            ]
        ]);
    
        // Baue die URL
        $uri = $uriBuilder
            ->reset()
            ->setArguments($queryParams)
            ->buildFrontendUri(); // In TYPO3 12.x wird cHash automatisch hinzugefügt
    
        $tagBuilder = GeneralUtility::makeInstance(TagBuilder::class, 'a');
        $tagBuilder->addAttribute('href', $uri);
        $tagBuilder->setContent($linkText);
        $tagBuilder->addAttribute('class', 'page-link');
    
        return $tagBuilder->render();
    }
    
    

    public function initializeArguments(): void
    {
        parent::initializeArguments();
        $this->registerArgument('currentPage', 'int', 'The current page number.', true);
        $this->registerArgument('totalPages', 'int', 'The total number of pages.', true);
        $this->registerArgument('itemsPerPage', 'int', 'The number of items per page.', true);
        $this->registerArgument('totalStones', 'int', 'The total number of stones.', true);
        $this->registerArgument('action', 'string', 'The action to link to.', false, 'list');
        $this->registerArgument('controller', 'string', 'The controller to link to.', false, 'Stone');
        $this->registerArgument('additionalParams', 'array', 'Additional arguments for the link.', false, []);
    }
}
