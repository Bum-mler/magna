<?php
declare(strict_types=1);

namespace Simplesigns\MlStonelexicon\Controller;

use Psr\Http\Message\ResponseInterface;
use Simplesigns\MlStonelexicon\Domain\Repository\PageRepository;
use TYPO3\CMS\Core\Pagination\ArrayPaginator;
use TYPO3\CMS\Core\Pagination\SimplePagination;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Core\Site\SiteFinder;
use TYPO3\CMS\Core\Site\Entity\Site;
use TYPO3\CMS\Frontend\Page\CacheHashCalculator;

class StoneController extends ActionController
{
    protected PageRepository $pageRepository;
    protected Site $currentSite;

    public function initializeAction(): void
    {
        $this->pageRepository = GeneralUtility::makeInstance(PageRepository::class);
        $siteFinder = GeneralUtility::makeInstance(SiteFinder::class);
        $this->currentSite = $siteFinder->getSiteByPageId((int)($GLOBALS['TSFE']->id ?? 0));
    }

    public function listAction(): ResponseInterface
    {
    
        $searchOrigin = $queryParams['tx_mlstonelexicon_lexicon']['searchOrigin'] ?? null;   

        $contentObj = $this->request->getAttribute('currentContentObject');
        if (!$contentObj) {
            throw new \RuntimeException('Content object not found', 9163909809);
        }
    
        $storagePids = explode(',', $contentObj->data['pages'] ?? '');
        $queryParams = $this->request->getQueryParams();

        \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($queryParams, 'Query Parameters in listAction');

        // $txParams initialisieren
        $txParams = $queryParams['tx_mlstonelexicon_lexicon'] ?? [];
    
        // Aktuelle Seite und Filterparameter auslesen
        $currentPage = max(1, filter_var($txParams['page'] ?? 1, FILTER_VALIDATE_INT));
        $itemsPerPage = (int)($this->settings['itemsPerPage'] ?? 12);
        $offset = ($currentPage - 1) * $itemsPerPage;
    
        // Filterparameter validieren und auslesen
        $searchColor = htmlspecialchars($txParams['searchColor'] ?? '', ENT_QUOTES);
        $searchOrigin = htmlspecialchars($txParams['searchOrigin'] ?? '', ENT_QUOTES);
    
        // Steine abrufen
        $stones = $this->pageRepository->findByFilter($storagePids, null, $searchColor, $searchOrigin, $itemsPerPage, $offset)->toArray();
        $totalStones = $this->pageRepository->countByFilter($storagePids, null, $searchColor, $searchOrigin);
    
        $totalPages = (int)ceil($totalStones / $itemsPerPage);
    
        $paginator = new ArrayPaginator($stones, $currentPage, $itemsPerPage);
        $pagination = new SimplePagination($paginator);
    
        // Filterarray erstellen
        $filterArray = $this->getFilterArray($stones);
    
        // cHash berechnen
        $cacheHashCalculator = GeneralUtility::makeInstance(CacheHashCalculator::class);
        $params = [
            'tx_mlstonelexicon_lexicon' => [
                'action' => 'list',
                'controller' => 'Stone',
                'searchColor' => $searchColor,
                'searchOrigin' => $searchOrigin,
            ]
        ];
        $cHash = $cacheHashCalculator->calculateCacheHash($params);
        \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($cHash, 'Calculated cHash');
    
        // Daten an die View übergeben
        $this->view->assignMultiple([
            'stones' => $paginator->getPaginatedItems(),
            'pagination' => $pagination,
            'totalStones' => $totalStones,
            'currentPage' => $currentPage,
            'itemsPerPage' => $itemsPerPage,
            'totalPages' => $totalPages,
            'searchColor' => $searchColor,
            'searchOrigin' => $searchOrigin,
            'allColors' => $filterArray['color'],
            'allOrigins' => $filterArray['origin'],
            'cHash' => $cHash,
        ]);
    
        return $this->htmlResponse();
    }

    private function getFilterArray($stones): array
    {
        $colorArray = [];
        $originArray = [];

        foreach ($stones as $stone) {
            if ($stone->getColor()) {
                self::addToFilterArray($colorArray, $stone->getColor());
            }
            if ($stone->getOrigin()) {
                self::addToFilterArray($originArray, $stone->getOrigin());
            }
        }

        ksort($colorArray);
        ksort($originArray);

        return [
            'color' => $colorArray,
            'origin' => $originArray,
        ];
    }

    private static function addToFilterArray(array &$array, $value): void
    {
        if ($value) {
            $array[$value] = $value;
        }
    }
}
