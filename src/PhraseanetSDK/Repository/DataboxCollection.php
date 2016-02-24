<?php

/*
 * This file is part of Phraseanet SDK.
 *
 * (c) Alchemy <info@alchemy.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhraseanetSDK\Repository;

use PhraseanetSDK\AbstractRepository;
use PhraseanetSDK\Exception\RuntimeException;
use Doctrine\Common\Collections\ArrayCollection;
use PhraseanetSDK\EntityHydrator;

class DataboxCollection extends AbstractRepository
{
    /**
     * Find all collection in the provided databox
     *
     * @param  integer          $databoxId the databox id
     * @return ArrayCollection|\PhraseanetSDK\Entity\DataboxCollection[]
     * @throws RuntimeException
     */
    public function findByDatabox($databoxId)
    {
        $response = $this->query('GET', sprintf('v1/databoxes/%d/collections/', $databoxId));

        if (true !== $response->hasProperty('collections')) {
            throw new RuntimeException('Missing "collections" property in response content');
        }

        return new ArrayCollection(\PhraseanetSDK\Entity\DataboxCollection::fromList(
            $response->getProperty('collections')
        ));
    }

    /**
     * Finds a collection in all available databoxes
     *
     * @param integer $baseId The base ID of the collection
     * @return \PhraseanetSDK\Entity\DataboxCollection
     * @throws \PhraseanetSDK\Exception\NotFoundException
     * @throws \PhraseanetSDK\Exception\UnauthorizedException
     */
    public function find($baseId)
    {
        $response = $this->query('GET', sprintf('v1/collections/%d/', $baseId));

        if ($response->hasProperty(('collection')) !== true) {
            throw new RuntimeException('Missing "collection" property in response content');
        }

        return \PhraseanetSDK\Entity\DataboxCollection::fromValue($response->getProperty('collection'));
    }
}
