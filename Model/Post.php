<?php
namespace Suraj\AdminGrid\Model;
class Post extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{
	const CACHE_TAG = 'suraj_admingrid_post';

	protected $_cacheTag = 'suraj_admingrid_post';

	protected $_eventPrefix = 'suraj_admingrid_post';

	protected function _construct()
	{
		$this->_init('Suraj\AdminGrid\Model\ResourceModel\Post');
	}

	public function getIdentities()
	{
		return [self::CACHE_TAG . '_' . $this->getId()];
	}

	public function getDefaultValues()
	{
		$values = [];

		return $values;
	}
}