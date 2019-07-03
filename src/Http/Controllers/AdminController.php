<?php

namespace FastDog\Admin\Http\Controllers;


use FastDog\Admin\Events\AdminMenuEvent;
use FastDog\Admin\Models\AdminMenu;
use FastDog\Admin\Models\Desktop;
use FastDog\Core\Http\Controllers\Controller;
use FastDog\Core\Models\DomainManager;
use FastDog\User\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class AdminController
 *
 * @package FastDog\Core\Controllers
 * @version 0.1.0
 * @author Андрей Мартынов <d.g.dev482@gmail.com>
 */
class AdminController extends Controller
{

    use AuthenticatesUsers;

    /**
     * @var string $redirectTo
     */
    protected $redirectTo = '/admin';

    /**
     * AdminController constructor.
     */
    public function __construct()
    {
        $this->middleware('FastDog\Admin\Http\Middleware\Admin')->except(['getLogin', 'postLogin']);
        parent::__construct();
    }

    /**
     * Главная страница администрирования
     *
     * @return \Illuminate\View\View
     */
    public function getIndex()
    {
        return view('admin::admin.dashboard');
    }

    /**
     * Страница авторизации
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getLogin()
    {
        return view('admin::admin.login');
    }

    /**
     * Авторизация
     *
     * @param Request $request
     * @return JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function postLogin(Request $request)
    {
        $request->merge([
            'type' => 'admin',
            'status' => 'active',
            'site_id' => DomainManager::getSiteId(),
        ]);

        return $this->login($request);
    }

    /**
     * Получение меню навигации по разделам администрирования
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMenu(Request $request): JsonResponse
    {
        $result = ['success' => false];
        $result['items'] = AdminMenu::get();

        /**
         * @var $user User
         */
        $user = \Auth::getUser();

        if ($user) {
            $user = User::find($user->id);
            $result['user'] = [
                'id' => $user->id,
                'name' => $user->getName(),
                'photo' => $user->getPhoto(),
            ];
        }
        event(new AdminMenuEvent($result));


        return $this->json($result, __METHOD__);
    }

    /**
     * Метод возвращает статистику отображаемую на главной странице
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDashboardStatistic(Request $request): JsonResponse
    {
        $result = ['success' => true, 'items' => [[]]];

        return $this->json($result, __METHOD__);
    }

    /**
     * Получение виджетов рабочего стола
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDesktop(Request $request): JsonResponse
    {
        $result = ['success' => true, 'items' => []];

        $items = Desktop::where(function (Builder $query) {
            $query->where(Desktop::SITE_ID, DomainManager::getSiteId());
        })->orderBy('sort')->get();
        /**
         * @var $item Desktop
         */
        foreach ($items as $item) {
            array_push($result['items'], $item->getData());
        }

        return $this->json($result, __METHOD__);
    }

    /**
     * Сортировка виджетов на рабочем столе
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postDesktopSort(Request $request): JsonResponse
    {
        $result = ['success' => true, 'items' => []];

        $updatePosition = $request->input('set', []);
        foreach ($updatePosition as $id => $position) {
            Desktop::where('id', $id)->update([
                Desktop::SORT => $position,
            ]);
        }

        return $this->json($result, __METHOD__);
    }

    /**
     * Удаление виджета с рабочего стола
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function postDesktopDelete(Request $request): JsonResponse
    {
        $widget = Desktop::where('id', $request->input('id'))->first();
        Desktop::check('N', [
            'name' => $widget->name,
            'type' => $widget->type,
        ]);

        return $this->json(['success' => true], __METHOD__);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getInterfaceRoute(Request $request): JsonResponse
    {
        $result = ['success' => true, 'routes' => []];

        return $this->json($result, __METHOD__);
    }
}
