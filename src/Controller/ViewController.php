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

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
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
     */
    public function view()
    {
        dd($this);
        $x = new Response('Hello');
        return $x;
    }
}