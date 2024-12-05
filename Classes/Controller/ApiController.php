<?php
declare(strict_types=1);

namespace Simplesigns\MlStonelexicon\Controller;

use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Http\JsonResponse;
use TYPO3\CMS\Frontend\Page\CacheHashCalculator;

class ApiController
{
    public function calculateCHashAction(): ResponseInterface
    {
        $queryParams = GeneralUtility::_GET('parameters') ?? '';
        $decodedParams = json_decode($queryParams, true);
    
        \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($decodedParams, 'Empfangene Parameter in calculateCHashAction');
    
        if (!is_array($decodedParams)) {
            return new JsonResponse(['error' => 'Invalid parameters'], 400);
        }
    
        try {
            $cacheHashCalculator = GeneralUtility::makeInstance(CacheHashCalculator::class);
            $cHash = $cacheHashCalculator->calculateCacheHash($decodedParams);
    
            return new JsonResponse(['cHash' => $cHash]);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Error calculating cHash: ' . $e->getMessage()], 500);
        }
    }
}    
