<?php
/**
 * Copyright © Hedeya. All rights reserved.
 */
namespace Hedeya\Branches\Api\Data;

interface BranchInterface
{
    const BRANCH_ID = "branch_id";
    const NAME = "name";
    const LAT = 'lat';
    const LNG = 'lng';
    const DESCRIPTION = 'description';
    /**
     * @return int|null
     */
    public function getId();

    /**
     * @param int $id
     * @return $this
     */
    public function setId($id);

    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $name
     * @return $this
     */
    public function setName($name);

    /**
     * @return string
     */
    public function getLatitude();

    /**
     * @param string $lat
     * @return $this
     */
    public function setLatitude($lat);

    /**
     * @return string
     */
    public function getLongitude();

    /**
     * @param string $longitude
     * @return $this
     */
    public function setLongitude($longitude);

    /**
     * @return string
     */
    public function getDescription();

    /**
     * @param string $description
     * @return $this
     */
    public function setDescription($description);
}
