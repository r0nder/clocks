<?php

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Routing\RouteCollectionBuilder;

require __DIR__ . '/vendor/autoload.php';

class AppKernel extends Kernel
{
    use MicroKernelTrait;

    /**
     * @inheritdoc
     */
    public function registerBundles()
    {
        return [
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle()
        ];
    }

    /**
     * @inheritdoc
     */
    protected function configureContainer(ContainerBuilder $c, LoaderInterface $loader)
    {
        $loader->load(__DIR__ . '/parameters.yml');
        $loader->load(__DIR__ . '/config.yml');
    }

    /**
     * @inheritdoc
     */
    protected function configureRoutes(RouteCollectionBuilder $routes)
    {
        $routes->add('/getDateTimeStrings', 'kernel:getDateTimeStringsAction');
    }

    /**
     * @return JsonResponse
     */
    public function getDateTimeStringsAction()
    {
        $container = $this->getContainer();

        try {
            $timezonesForResponse = $container->getParameter('timezones_for_response');
        } catch (InvalidArgumentException $invalidArgumentException) {
            return $this->printException($invalidArgumentException);
        }

        $dateTime = new DateTime();
        $dateTimeStringsForResponse = [];

        foreach ($timezonesForResponse as $timezone) {
            try {
                $dateTime->setTimezone(new \DateTimeZone($timezone));
            } catch (Exception $exception) {
                return $this->printException($exception);
            }

            $dateTimeStringsForResponse[$timezone] = $dateTime->format("Y-m-d H:i:s");
        }

        return $this->createResponse($dateTimeStringsForResponse);
    }

    /**
     * @param string $content
     * @param int $httpCode
     * @return JsonResponse
     */
    private function createResponse($content, $httpCode = Response::HTTP_OK)
    {
        return new JsonResponse($content, $httpCode);
    }

    /**
     * @param Exception $exception
     * @return JsonResponse
     */
    private function printException(Exception $exception)
    {
        return $this->createResponse([
            "message" => $exception->getMessage()
        ], Response::HTTP_BAD_REQUEST);
    }
}

$kernel = new AppKernel('prod', true);
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
