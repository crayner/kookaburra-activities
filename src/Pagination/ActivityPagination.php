<?php
/**
 * Created by PhpStorm.
 *
 * Kookaburra
 * (c) 2020 Craig Rayner <craig@craigrayner.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * User: craig
 * Date: 11/02/2020
 * Time: 14:19
 */

namespace Kookaburra\Activities\Pagination;


use App\Manager\Entity\PaginationAction;
use App\Manager\Entity\PaginationColumn;
use App\Manager\Entity\PaginationRow;
use App\Manager\PaginationInterface;
use App\Manager\AbstractPaginationManager;
use App\Util\TranslationsHelper;

class ActivityPagination extends AbstractPaginationManager
{

    public function execute(): PaginationInterface
    {
        TranslationsHelper::setDomain('Activities');
        $row = new PaginationRow();

        $column = new PaginationColumn();
        $column->setLabel('Activity')
            ->setHelp('Type')
            ->setContentKey(['name','activityType'])
            ->setSort(true)
            ->setSearch(true)
            ->setClass('column relative pr-4 cursor-pointer widthAuto')
        ;
        $row->addColumn($column);

        $column = new PaginationColumn();
        $column->setLabel('Provider')
            ->setContentKey('provider')
            ->setClass('column relative pr-4 cursor-pointer widthAuto')
        ;
        $row->addColumn($column);

        $column = new PaginationColumn();
        $column->setLabel('Terms')
            ->setHelp('Days')
            ->setContentKey(['terms','days'])
            ->setClass('column relative pr-4 cursor-pointer widthMax10')
        ;
        $row->addColumn($column);

        $column = new PaginationColumn();
        $column->setLabel('Years')
            ->setContentKey(['years'])
            ->setClass('column relative pr-4 cursor-pointer widthMax10')
        ;
        $row->addColumn($column);

        $column = new PaginationColumn();
        $column->setLabel('Cost')
            ->setHelp('AUD $')
            ->setContentKey(['cost'])
            ->setClass('column relative pr-4 cursor-pointer widthAuto')
        ;
        $row->addColumn($column);

        $action = new PaginationAction();
        $action->setTitle('View')
            ->setColumnClass('column p-2 sm:p-3')
            ->setSpanClass('fas fa-info fa-fw fa-1-5x text-gray-700')
            ->setOnClick('displayInformation')
            ->setRoute('activities__details')
            ->setDisplayWhen('access')
            ->setRouteParams(['activity' => 'id']);
        $row->addAction($action);

        $this->setRow($row);
        return $this;
    }
}