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

use Kookaburra\SystemAdmin\Entity\Setting;
use App\Provider\ProviderFactory;
use Kookaburra\Activities\Entity\Activity;
use Kookaburra\Activities\Pagination\ActivityPagination;
use Kookaburra\UserAdmin\Util\SecurityHelper;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
     * @Route("/", name="view_home")
     * @Security("is_granted('ROLE_ROUTE', ['activities__view'])")
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
     * @Route("/{activity}/details/", name="details")
     * @IsGranted("ROLE_ROUTE")
     * @return JsonResponse
     */
    public function display(Activity $activity)
    {
        $options = Activity::getTypelist();
        return new JsonResponse([
            'content' => $this->renderView('@KookaburraActivities/details.html.twig',
                [
                    'activity' => $activity,
                    'activityTypes' => count($options) === 0 ? null : $activity->getType(),
                    'activityByType' => ProviderFactory::create(Setting::class)->getSettingByScopeAsString('Activities', 'dateType'),
                    'hideExternalProviderCost' => ProviderFactory::create(Setting::class)->getSettingByScopeAsBoolean('Activities', 'hideExternalProviderCost'),
                    'access' => ProviderFactory::create(Setting::class)->getSettingByScopeAsString('Activities', 'access'),
                    'highestAction' => SecurityHelper::getHighestGroupedAction('activities__details'),
                ]
            ),
            'header' => $activity->getName(),
        ], 200);
    }
}