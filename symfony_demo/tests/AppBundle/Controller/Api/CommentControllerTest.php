<?php

namespace Tests\AppBundle\Controller\Api;

use Draw\Bundle\DrawTestHelperBundle\Helper\WebTestCaseTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CommentControllerTest extends WebTestCase
{
    use WebTestCaseTrait;

    public function testListAction()
    {
        $this->requestHelper()
            ->get('/posts/1/comments')
            ->jsonHelper()

            // @todo some checks

            ->executeAndJsonDecode();
    }
}