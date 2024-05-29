<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PortfolioModel;
use CodeIgniter\HTTP\ResponseInterface;

class PortfolioController extends BaseController
{
    
    public $helpers = [
        'form'
    ];

    public function index()
    {
        // mengambil semua data porfolio dari tabel portfolios
        $model = new PortfolioModel();
        $portfolios = $model->findAll();
        
        $data = [
            'portfolios' => $portfolios
        ];

        // mengirimkan data portfolio ke View
        echo view('portfolio/index', $data);
    }

    public function create()
    {
        // jika HTTP method adalah "POST" dan data yang dikirim valid, maka akan melakukan proses selanjutnya
        if ($this->request->getMethod() === 'POST' && $this->validate([
            
            'title' => 'required',
            'description' => 'required',
            'image' => 'uploaded[image]|ext_in[image,png,jpg,jpeg]'
        ])) {
                // menyimpan file gambar dari input file
                $imageFile = $this->request->getFile('image');
                $imageFileName = $imageFile->getRandomName();
                $imageFile->move(ROOTPATH . 'public/images/',$imageFileName);

                // mengambil data entity portfolio dari request form
                $portfolio = new \App\Entities\Portfolio();
                $portfolio->title = $this->request->getPost('title');
                $portfolio->description = $this->request->getPost('description');
                $portfolio->image = "images/" . $imageFileName;
                
                // menyimpan data entity portfolio ke tabel portfolios
                $model = model('App\Models\PortfolioModel');
                $model->save($portfolio);

                // redirect ke halaman dengan route `/portfolio` dengan mengeset flashdata untuk menampilkan pesan sukses
                return redirect()->to('/portfolio')->with('success_message', 'Successfully create a new portfolio.');
            }
            // jika HTTP method adalah "POST" dan data yang dikirim tidak valid, maka akan mengirimkan pesan eror

            elseif ($this->request->getMethod() === 'POST') {
                return redirect()->to('/portfolio/create')->withInput()->with('errors', $this->validator->getErrors());

            }
        // handle untuk request dengan method "get"
        echo view('portfolio/create');
    }
    public function update($id)
    {
        $model = new PortfolioModel();
        //mengambil data portfolio berdasarkan parameter $id
        if (! $portfolio = $model->find($id)) {
            // jika data portfolio tidak ditemukan, maka akan dialihkan ke halaman 404
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        // handle untuk request dengan method "post"
        // mengecek apakah request http method = "post" dan apakah data yang dikirim valid atau tidak
        if ($this->request->getMethod() === 'POST' && $this->validate([
            'title' => 'required',
            'description' => 'required',
            'image' => 'ext_in[image,png,jpg,jpeg]'
        ])) {
                $imageFile = $this->request->getFile('image');
                $imageFileName = $imageFile->getRandomName();
                if($imageFile->isValid()) {
                    //menghapus file gambar sebelumnya
                    unlink(ROOTPATH.'public/'.$portfolio->image);
                    //menyimpan file gambar baru dari input file
                    $imageFile->move(ROOTPATH.'public/images/', $imageFileName);
                    $portfolio->image = "images/".$imageFileName;
                }
                $portfolio->title = $this->request->getPost('title');
                $portfolio->description = $this->request->getPost('description');
                // jika terdapat perubahan, simpan perubahan data portfolio ke tabel portfolios
                if ($portfolio->hasChanged()) {
                    $model->save($portfolio);
                }
                return redirect()->to('/portfolio')->with('success_message','Successfuly update portfolio.');
            }
            // jika HTTP method adalah "POST" dan data yang dikirim tidak valid, maka akan mengirimkan pesan eror
            elseif ($this->request->getMethod() === 'POST') {
                return redirect()->to('/portfolio/update/'.$portfolio->id)->withInput()->with('errors', $this->validator->getErrors());
            }

        // handle untuk request dengan method "get"
        $data = [
            'portfolio' => $portfolio
        ];
        echo view('portfolio/update', $data);
    }
    public function destroy($id)
    {
        $model = new PortfolioModel();

        //handle untuk request dengan method "delete"
        if($this->request->getMethod() === 'DELETE') {
            if (! $portfolio = $model->find($id)) {
            // jika data portfolio tidak ditemukan, maka akan dialihkan ke halaman 404
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
            }
            // hapus data portfolio dari tabel portfolios
            $model->delete($portfolio->id);
        }
        //handle untuk request dengan method selain "delete"
        return redirect()->to('/portfolio');
    }
}
