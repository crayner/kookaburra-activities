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
 * Date: 14/02/2020
 * Time: 08:36
 */

namespace Kookaburra\Activities\Controller;

use App\Provider\ProviderFactory;
use Kookaburra\Activities\Entity\Activity;
use Kookaburra\Activities\Pagination\ActivityManagePagination;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ManageController
 * @package Kookaburra\Activities\Controller
 */
class ManageController extends AbstractController
{
    /**
     * manage
     * @Route("/manage/", name="manage")
     */
    public function manage(ActivityManagePagination $pagination)
    {
        $content = ProviderFactory::getRepository(Activity::class)->findForPagination(false);
        $pagination->setContent($content)
            ->setPaginationScript();
        return $this->render('@KookaburraActivities/manage.html.twig');
    }
}