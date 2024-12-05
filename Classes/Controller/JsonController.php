<?php
declare(strict_types=1);

namespace Simplesigns\MlStonelexicon\Controller;

// packages/ml_stonelexicon/Classes/Controller/JsonController.php

use Doctrine\DBAL\Connection;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Core\Http\Response;
use TYPO3\CMS\Extbase\Mvc\Web\Routing\UriBuilder;
use TYPO3\CMS\Core\Log\LogManager;

/**
 * Controller zur Bereitstellung von JSON-Antworten für AJAX-Requests.
 * 
 * Dieser Controller durchsucht die Tabelle `pages` basierend auf einem Suchbegriff
 * und liefert die Ergebnisse als JSON zurück.
 */
class JsonController extends ActionController
{
    /**
     * Liefert eine JSON-Antwort mit Seiten, die dem Suchbegriff entsprechen.
     *
     * Die Suche erfolgt auf den `title`-Feld der Tabelle `pages` und berücksichtigt nur
     * spezifische PIDs und Doktypen. Es werden maximal 5 Suchbegriffe verarbeitet.
     *
     * @return ResponseInterface JSON-Antwort mit Suchergebnissen oder Fehlern
     */
    public function listJsonAction(): ResponseInterface
    {
        // Suchbegriff aus Anfrage extrahieren
        $term = trim($this->request->getParsedBody()['term'] ?? $this->request->getQueryParams()['term'] ?? '');
    
        // Sicherheit: Filterung des Suchbegriffs
        $term = htmlspecialchars($term, ENT_QUOTES, 'UTF-8');
    
        // Filterparameter aus Anfrage
        $searchColor = htmlspecialchars($this->request->getQueryParams()['color'] ?? '', ENT_QUOTES);
        $searchAbbaurt = htmlspecialchars($this->request->getQueryParams()['abbaurt'] ?? '', ENT_QUOTES);
    
        // PIDs und Doktypen, die berücksichtigt werden sollen
        $pids = [169]; // Beispieldaten
        $doktypes = [169];
    
        // QueryBuilder instanziieren
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('pages');
    
        // Dynamische Bedingungen aufbauen
        $conditions = [];
    
        // Filter: Suchbegriff
        if (!empty($term)) {
            $preparedSearch = array_map(
                static fn($s) => $queryBuilder->expr()->like('title', $queryBuilder->quote('%' . $s . '%')),
                explode(' ', $term, 5)
            );
            $conditions[] = $queryBuilder->expr()->or(...$preparedSearch);
        }
    
        // Filter: Farbe
        if (!empty($searchColor)) {
            $conditions[] = $queryBuilder->expr()->like('color', $queryBuilder->quote('%' . $searchColor . '%'));
        }
    
        // Filter: Abbaurt
        if (!empty($searchAbbaurt)) {
            $conditions[] = $queryBuilder->expr()->like('abbaurt', $queryBuilder->quote('%' . $searchAbbaurt . '%'));
        }
    
        // Filter: PID und Doktyp
        $conditions[] = $queryBuilder->expr()->in('pid', $queryBuilder->createNamedParameter($pids, Connection::PARAM_INT_ARRAY));
        $conditions[] = $queryBuilder->expr()->in('doktype', $queryBuilder->createNamedParameter($doktypes, Connection::PARAM_INT_ARRAY));
    
        // Debugging der Bedingungen
        \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($conditions, 'Query Conditions');
    
        try {
            // Abfrage ausführen
            $result = $queryBuilder->select('uid', 'title')
                ->from('pages')
                ->where(...$conditions)
                ->executeQuery()
                ->fetchAllAssociative();
    
            // Prüfen, ob Ergebnisse vorliegen
            if (empty($result)) {
                return $this->jsonResponse(json_encode(['error' => 'Fehlerhafte Anfrage']), 400);
            }
    
            // Ergebnisse aufbereiten
            $output = [];
            foreach ($result as $row) {
                $output[] = [
                    'id' => $row['uid'],
                    'label' => $row['title'],
                    'value' => $row['title'], // Hier ggf. URL oder anderer Wert
                ];
            }
    
            return $this->jsonResponse(json_encode($output));
        } catch (\Exception $e) {
            // Fehlerbehandlung
            $this->logError('Ein Fehler ist aufgetreten: ' . $e->getMessage());
            return $this->jsonResponse(json_encode(['error' => 'Ein Fehler ist aufgetreten.']), 500);
        }
    }
    

    /**
     * Erzeugt eine JSON-Antwort mit dem angegebenen Inhalt und Statuscode.
     *
     * @param string|null $json Der JSON-Inhalt der Antwort.
     * @param int $statusCode Der HTTP-Statuscode der Antwort.
     * @return ResponseInterface JSON-Antwort
     */
    protected function jsonResponse(?string $json = null, int $statusCode = 200): ResponseInterface
    {
        $response = new Response();
        $response->getBody()->write($json ?? '');
        return $response->withStatus($statusCode)->withHeader('Content-Type', 'application/json');
    }

    public function calculateChashAction(ServerRequestInterface $request): ResponseInterface
    {
        $parameters = $request->getQueryParams()['parameters'] ?? null;
        if ($parameters === null) {
            return $this->jsonResponse(['error' => 'Parameters missing'], 400);
        }
    
        $cacheHashCalculator = GeneralUtility::makeInstance(CacheHashCalculator::class);
        $cHash = $cacheHashCalculator->calculateCacheHash(json_decode($parameters, true));
    
        return $this->jsonResponse(['cHash' => $cHash]);
    }
    

    /**
     * Protokolliert eine Fehlermeldung mit Kontextinformationen.
     *
     * @param string $message Die Fehlermeldung.
     */
    protected function logError(string $message): void
    {
        $logger = GeneralUtility::makeInstance(LogManager::class)->getLogger(__CLASS__);
        $logger->error($message, [
            'context' => 'JsonController',
            'request' => $this->request->getQueryParams()
        ]);
    }
}
