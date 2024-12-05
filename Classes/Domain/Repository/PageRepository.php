<?php
declare(strict_types=1);

namespace Simplesigns\MlStonelexicon\Domain\Repository;

// packages/ml_stonelexicon/Classes/Domain/Repository/PageRepository.php

use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

class PageRepository extends Repository
{
    // Standardmäßige Sortierung nach PID und Titel in aufsteigender Reihenfolge
    protected $defaultOrderings = ['pid' => QueryInterface::ORDER_ASCENDING, 'title' => QueryInterface::ORDER_ASCENDING];

    /**
     * Findet alle Seiten mit optionalen Einschränkungen auf bestimmte PIDs
     * 
     * @param array $pids Liste von PIDs, auf die die Suche eingeschränkt werden soll
     * @return \TYPO3\CMS\Extbase\Persistence\QueryResultInterface|array
     */
    public function findAll($pids = [])
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);

        if (!empty($pids)) {
            $query->matching($query->in('pid', $pids));
        }

        return $query->execute();
    }

    /**
     * Findet Seiten basierend auf verschiedenen Filterkriterien
     * 
     * @param array $pids Liste von PIDs, auf die die Suche eingeschränkt werden soll
     * @param string|null $string Suchbegriff, der im Titel oder Untertitel vorkommen soll
     * @param string|null $color Farbe des Steins
     * @param string|null $origin Herkunft des Steins
     * @param int $limit Anzahl der zurückzugebenden Ergebnisse
     * @param int $offset Offset für die Paginierung
     * @return \TYPO3\CMS\Extbase\Persistence\QueryResultInterface|array
     */
    public function findByFilter($pids = [], $string = null, $color = null, $origin = null, $limit = 10, $offset = 0)
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
    
        $constraints = [];
    
        // Einschränkung auf bestimmte PIDs
        if (!empty($pids)) {
            $constraints[] = $query->in('pid', $pids);
        }
    
        // Einschränkung auf eine bestimmte Farbe
        if (!empty($color)) {
            $constraints[] = $query->equals('color', $color);
        }
    
        // Anwenden der Einschränkungen
        if (!empty($constraints)) {
            $query->matching($query->logicalAnd(...$constraints));
        }
    
        // Limit und Offset für Paginierung
        $query->setLimit((int)$limit);
        $query->setOffset((int)$offset);
    
        return $query->execute();
    }
    

    /**
     * Zählt die Anzahl der Seiten basierend auf verschiedenen Filterkriterien
     * 
     * @param array $pids Liste von PIDs, auf die die Suche eingeschränkt werden soll
     * @param string|null $string Suchbegriff, der im Titel oder Untertitel vorkommen soll
     * @param string|null $color Farbe des Steins
     * @param string|null $origin Herkunft des Steins
     * @return int Anzahl der übereinstimmenden Seiten
     */
    public function countByFilter($pids = [], $string = null, $color = null, $origin = null): int
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false); // Ignoriert die standardmäßige Einschränkung auf die Storage-Seite
    
        $constraints = [];
    
        // Einschränkung auf bestimmte PIDs
        if (!empty($pids)) {
            $constraints[] = $query->in('pid', $pids);
        }
    
        // Suchbegriff im Titel oder Untertitel
        if (!empty($string)) {
            $searchConstraints = [];
            foreach (explode(' ', $string) as $s) {
                $searchConstraints[] = $query->like('title', '%' . $s . '%');
                $searchConstraints[] = $query->like('subtitle', '%' . $s . '%');
            }
            $constraints[] = $query->logicalOr(...$searchConstraints);
        }
    
        // Einschränkung auf eine bestimmte Farbe
        if (!empty($color)) {
            $constraints[] = $query->equals('color', $color);
        }
    
        // Einschränkung auf eine bestimmte Herkunft
        if (!empty($origin)) {
            $constraints[] = $query->like('origin', '%' . $origin . '%');
        }
    
        \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($origin, 'Filter: origin');

        // Anwenden der Einschränkungen, falls vorhanden
        if (!empty($constraints)) {
            $query->matching($query->logicalAnd(...$constraints));
        }
    
        return $query->count();
    }    
}
