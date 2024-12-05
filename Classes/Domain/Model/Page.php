<?php
declare(strict_types=1);

namespace Simplesigns\MlStonelexicon\Domain\Model;

// packages/ml_stonelexicon/Classes/Domain/Model/Page.php

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class Page extends AbstractEntity
{
    /**
     * @var string
     */
    protected string $title = '';

    /**
     * @var string
     */
    protected string $subtitle = '';

    /**
     * @var string
     */
    protected string $origin = '';

    /**
     * @var int
     */
    protected int $color = 0;

    // Getter methods
    public function getTitle(): string
    {
        return $this->title;
    }

    public function getSubtitle(): string
    {
        return $this->subtitle;
    }

    public function getOrigin(): string
    {
        return $this->origin;
    }

    public function getColor(): int
    {
        return $this->color;
    }
}
