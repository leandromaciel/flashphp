<?php
namespace NotifyMe\Core;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use NotifyMe\Singleton\Core_Singleton;


class DB_Factory {

	public $Entity_Manager;
	public $Query_Builder;

    private $Entity_Name;
    private $proxyDir = PROXY_PATH;
    private $Core;

	protected $dbParams;
    protected $recordsLimit;
    protected $firstResult;
    protected $lastResult;

	private $entityPaths = array(ENTITY_PATH);

	private $isDevMode = true;

	public function __construct(array $settingsData = null) {

        if ( !is_null($settingsData) ) {
			$this->dbParams = $settingsData;
            $this->setRecordsLimit();
        }

		$this->setEntityManager();

		return $this->getEntityManager();
	}

    public function getRecordsLimit() {
        return $this->recordsLimit;
    }

    public function setRecordsLimit() {

        $this->Core = Core_Singleton::getInstance();
        $Security = $this->Core->getSecurity();

        if ( isset($_POST['resultsPerPage']) ) {
            $Security->registerSession('pagination', array('resultsPerPage' => $_POST['resultsPerPage']));
        }

        $paginationData = $Security->getSessionData('pagination');

        if ( $paginationData !== NULL ) {
            $this->recordsLimit = $paginationData['resultsPerPage'];
        } else {
            $this->recordsLimit = $this->dbParams['records_limit'];
        }
    }

    public function setFirstResult($firstResult) {
        $this->firstResult = $firstResult;
    }

    public function getFirstResult() {
        return $this->firstResult;
    }

    public function setLastResult($lastResult) {
        $this->lastResult = $lastResult;
    }

    public function getLastResult() {

        if ( $this->getTotalResultsFound() < $this->lastResult ) {
            return $this->getTotalResultsFound();
        } else {
            return $this->lastResult;
        }
    }

	public function setEntityManager() {

		$setup = Setup::createAnnotationMetadataConfiguration($this->entityPaths, $this->isDevMode, $this->proxyDir);

		$this->Entity_Manager = EntityManager::create($this->dbParams, $setup);
	}

	public function getEntityManager() {
		return $this->Entity_Manager;
	}

	public function setQueryBuilder() {

		$this->Entity_Manager->getClassMetadata($this->Entity_Name);
		$this->Query_Builder = $this->Entity_Manager->createQueryBuilder();
	}

	public function getQueryBuilder() {
		return $this->Query_Builder;
	}

	public function setEntityName($EntityName) {
		$this->Entity_Name = $EntityName;
	}

	public function getEntityName() {
		return $this->Entity_Name;
	}

	public function getEntityIds($alias, array $fields = null, array $where = null, $whereType = 'AND') {

        if ( $fields === NULL ) {
            $fields = array('id');
        }

		$result = $this->getEntityFields($alias, $fields, $where, $whereType, null, null);
		$entityIds = [];

		foreach( $result as $id => $value ) {

			$entityIds[] = $value['id'];
		}

		return $entityIds;
	}

    public function getEntityFields($alias, array $fields = null, array $where = null, $whereType = 'AND', array $orderBy = null, array $limit = null) {

		$this->setSelectData($alias, $fields);
		$this->setFromData($alias);

        if ( $whereType == 'AND' ) {
            $this->setWhereData($alias, $where);
        }

        if ( $whereType == 'OR' ) {
            $this->setOrWhereData($alias, $where);
        }

        $this->setOrderByData($alias, $orderBy);
        $this->setLimitData($limit);

		$result = $this->Query_Builder->getQuery()->getResult();

        $this->setQueryBuilder();

		return $result;
	}

	public function setSelectData($alias, array $fields = null) {

		if ( is_array($fields) ) {

			$aliasFields = [];

			foreach ( $fields as $key => $field ) {
				$aliasFields[] = $alias.'.'.$field;
			}

			$allFields = implode(', ', $aliasFields);

			$this->Query_Builder->select($allFields);
		} else {
			$this->Query_Builder->select($alias);
		}
	}

	public function setFromData($alias) {
		$this->Query_Builder->from($this->Entity_Name, $alias);
	}

	public function setWhereData($alias, array $where = null) {

		if ( is_array($where) ) {
			foreach ( $where as $field => $conditionValue ) {
				$this->Query_Builder->andwhere("{$alias}.{$field} {$conditionValue}");
			}
		}
	}

    public function setOrWhereData($alias, array $where = null) {

        if ( is_array($where) ) {
            foreach ( $where as $field => $conditionValue ) {
                $this->Query_Builder->orWhere("{$alias}.{$field} {$conditionValue}");
            }
        }
    }

	public function setOrderByData($alias, array $orderBy = null) {

		if ( is_array($orderBy) ) {
			foreach ( $orderBy as $field => $orderValue ) {
				$this->Query_Builder->addOrderBy($alias.'.'.$field, $orderValue);
			}
		}
	}

    public function setLimitData(array $limit = null) {

        if ( is_array($limit) ) {

            if ( isset($limit['first']) && isset($limit['max']) ) {
                $this->Query_Builder->setFirstResult($limit['first']);
                $this->Query_Builder->setMaxResults($limit['max']);

                return true;
            }
        }
    }

    public function prepareLimit($totalRecords = null, $pageNumber = null) {

        if ( is_null($totalRecords) ) {
            $limit['max'] = $this->getRecordsLimit();
        } else {
            $limit['max'] = $totalRecords;
        }

        if ( is_null($pageNumber) ) {
            $limit['first'] = 0;

            $firstResult = ($limit['first'] + 1);
        } else {

            $this->Core = Core_Singleton::getInstance();
            $Language = $this->Core->getLanguage();

            if ( strpos($pageNumber, $Language->getWord('page-')) !== FALSE ) {
                $pageNumber = str_replace($Language->getWord('page-'), '', $pageNumber);
            }

            $limit['first'] = ((($pageNumber - 1) * $limit['max']) +1);
            $firstResult = ($limit['first']);
        }

        $lastResult = ($limit['first'] + $limit['max']);

        $this->setFirstResult($firstResult);
        $this->setLastResult($lastResult);

        return $limit;
    }
}