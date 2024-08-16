<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UrlModel;
use chillerlan\QRCode\QRCode;

class User extends BaseController
{
    public function index()
    {
        $urlModel = new UrlModel();

        $data['tittle'] = 'ShortURL - URL Shortener';

        $data['listUrl'] = $urlModel->orderBy('count', 'desc')->findAll('15', '0');

        return view('pages/home', $data);
    }

    public function genUrl()
    {
        $input = $this->validate([
            'url' => 'required|min_length[3]|max_length[10000]|valid_url',
        ]);

        if (!$input) {
            session()->setFlashdata('err', $this->validator->listErrors());
        } else {

            $fullUrl = $this->request->getVar('url');

            // Loading Helper text
            helper('text');

            $n = 5;
            $slug = $this->janaURL($n);

            // $slug = random_string('alnum', 5);
            $qrImg = (new QRCode)->render(base_url($slug));

            $urlModel = new UrlModel();
            $urlModel->save([
                'slug' => $slug,
                'full_url' => $fullUrl,
                'qr' => $qrImg,
            ]);

            $res = [
                'slug' => $slug,
                'fullUrl' => $fullUrl,
                'img' => $qrImg,
            ];

            session()->setFlashdata('url', $res);
        }

        return redirect()->to(route_to('User::index'));
    }

    public function redirect()
    {
        $getSlug = $this->request->getPath();
        $urlModel = new UrlModel();

        $data = $urlModel->where('slug', $getSlug)->first();

        if ($data === null) {
            return redirect()->to('/');
        }

        $params = [
            'last_visit_at' => date('Y-m-d H:i:s'),
            'count' => $data['count'] + 1,
        ];

        $urlModel->update($data['id'], $params);

        return redirect()->to($data['full_url']);
    }

    public function janaURL($n)
    {
        $characters = '123456789abcdefghijklmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ';
        $randomString = '';

        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }

        return $randomString;
    }
}
