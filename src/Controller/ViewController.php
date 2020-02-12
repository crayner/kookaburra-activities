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
 * Time: 09:42
 */

namespace Kookaburra\Activities\Controller;

use App\Provider\ProviderFactory;
use Kookaburra\Activities\Entity\Activity;
use Kookaburra\Activities\Pagination\ActivityPagination;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ViewController
 * @package Kookaburra\Activities\Controller
 */
class ViewController extends AbstractController
{
    /**
     * view
     * @Route("/view/", name="view")
     * @IsGranted("ROLE_ROUTE")
     * @param ActivityPagination $pagination
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function view(ActivityPagination $pagination)
    {
        $content = ProviderFactory::getRepository(Activity::class)->findForPagination();
        $pagination->setContent($content)
            ->setPaginationScript();
        return $this->render('@KookaburraActivities/view.html.twig');
    }

    /**
     * display
     * @param Activity $activity
     * @Route("/{activity}/display/", name="display")
     */
    public function display(Activity $activity)
    {

    }
}