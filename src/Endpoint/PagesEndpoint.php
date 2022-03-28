<?php

declare(strict_types=1);

namespace Brd6\NotionSdkPhp\Endpoint;

use Brd6\NotionSdkPhp\Exception\ApiResponseException;
use Brd6\NotionSdkPhp\Exception\HttpResponseException;
use Brd6\NotionSdkPhp\Exception\InvalidResourceException;
use Brd6\NotionSdkPhp\Exception\InvalidResourceTypeException;
use Brd6\NotionSdkPhp\Exception\RequestTimeoutException;
use Brd6\NotionSdkPhp\RequestParameters;
use Brd6\NotionSdkPhp\Resource\Block\AbstractBlock;
use Brd6\NotionSdkPhp\Resource\Page;

use function array_map;
use function array_merge;

class PagesEndpoint extends AbstractEndpoint
{
    /**
     * @throws ApiResponseException
     * @throws HttpResponseException
     * @throws RequestTimeoutException
     * @throws InvalidResourceException
     * @throws InvalidResourceTypeException
     */
    public function retrieve(string $pageId): Page
    {
        $requestParameters = (new RequestParameters())
            ->setPath("pages/$pageId")
            ->setMethod('GET');

        $rawData = $this->getClient()->request($requestParameters);

        /** @var Page $page */
        $page = Page::fromRawData($rawData);

        return $page;
    }

    /**
     * @param Page $page
     * @param array|AbstractBlock[] $children
     *
     * @throws ApiResponseException
     * @throws HttpResponseException
     * @throws InvalidResourceException
     * @throws InvalidResourceTypeException
     * @throws RequestTimeoutException
     */
    public function create(Page $page, array $children = []): Page
    {
        $childrenData = array_map(fn (AbstractBlock $block) => $block->toJson(), $children);

        $data = array_merge($page->toJson(), ['children' => $childrenData]);

        $requestParameters = (new RequestParameters())
            ->setPath('pages')
            ->setMethod('POST')
            ->setBody($data);

        $rawData = $this->getClient()->request($requestParameters);

        /** @var Page $pageCreated */
        $pageCreated = Page::fromRawData($rawData);

        return $pageCreated;
    }
}
