<?php
/*
 * @author Magebrew
 * @copyright Copyright (c) 2019 Magebrew
 * @package Magebrew_ImageUploadFormField
 */

declare(strict_types=1);

namespace Magebrew\ImageUploadFormField\ViewModel;

use Magebrew\ImageUploadFormField\Model\BannerUploader;
use Magento\Cms\Model\Page;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class BannerViewModel
 */
class BannerViewModel implements ArgumentInterface
{
    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var Page
     */
    private $page;

    /**
     * BannerViewModel constructor.
     * @param Page $page
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        Page $page,
        StoreManagerInterface $storeManager
    )
    {
        $this->page = $page;
        $this->storeManager = $storeManager;
    }

    /**
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getBannerImageUrl(): ?string
    {
        $image = $this->page->getBannerImage();
        return $this->getImagePath($image);
    }

    /**
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getBannerImageMobileUrl(): ?string
    {
        $image = $this->page->getBannerImageMobile();
        if (empty($image)) return $this->getBannerImageTabletUrl();
        return $this->getImagePath($image);
    }

    /**
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getBannerImageTabletUrl(): ?string
    {
        $image = $this->page->getBannerImageTablet();
        if (empty($image)) return $this->getBannerImageUrl();
        return $this->getImagePath($image);
    }

    public function getImagePath($image) {
        if(empty($image)) return '';
        return $this->storeManager->getStore()
                ->getBaseUrl(UrlInterface::URL_TYPE_MEDIA) .
            BannerUploader::IMAGE_PATH . DIRECTORY_SEPARATOR . $image;
    }

}
