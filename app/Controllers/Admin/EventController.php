<?php
namespace App\Controllers\Admin;

use App\Models\Event;
use App\Models\GoingEvent;
use App\Models\InterestedEvent;
use App\Controllers\BaseController;
use App\Controllers\Admin\AdminBaseController;

class eventController extends AdminBaseController
{
    private $eventModel;
    public  $session;

    public function __construct()
    {
        parent::__construct();
        $this->session = \Config\Services::session();
        $this->eventModel = new event();
    }

    public function index()
    {
        $this->data['page_title'] = lang('Admin.all_events'); // Translated string for "All events"
        $this->data['breadcrumbs'][] = ['name' => lang('Admin.all_events'), 'url' => '']; 
        $this->data['events'] = $this->eventModel->getAllEventes();
        return view('admin/pages/all-events', $this->data);
    }

    public function create()
    {
        $this->data['page_title'] = lang('Admin.create_new_event'); // Translated string for "Create new event"
        $this->data['js_files'] = ['assets/js/jquery.validate.min.js'];
        $this->data['breadcrumbs'][] = ['name' => lang('Admin.website_information'), 'url' => '']; // Translated string for "Website Information"

        return view('admin/pages/events/create', $this->data);
    }


    public function store()

    {

        $rules = [
            'name' => 'required',
            'location' => 'required',
            'start_date' => 'required',
            'start_time' => 'required',
            'end_date' => 'required',
            'end_time' => 'required',
            // 'cover' => 'uploaded[cover]|max_size[cover,1024]|mime_in[cover,image/jpg,image/jpeg,image/png]',
        ];

        if ($this->validate($rules)) {

            $inserted_data = [
                'user_id' => getCurrentUser()['id'],
                'name' => $this->request->getVar('name'),
                'location' => $this->request->getVar('location'),
                'description' => $this->request->getVar('description'),
                'start_date' => $this->request->getVar('start_date'),
                'start_time' => $this->request->getVar('start_time'),
                'end_date' => $this->request->getVar('end_date'),
                'end_time' => $this->request->getVar('end_time'),
                'url' => $this->request->getVar('url'),
            ];
            $avatar  = $this->request->getFile('avatar');
            $background_image = $this->request->getFile('background_image');
            $cover = $this->request->getFile('cover');

            $this->eventModel->save($inserted_data);
            return redirect('admin/events');
        } else {
            $validationErrors = $this->validator->getErrors();
            return view('admin/pages/events/create', ['validation' => $validationErrors]);
        }
    }

    public function edit($id)
    {
        $this->data['page_title'] = lang('Admin.edit_event'); // Translated string for "Edit event"
        $this->data['js_files'] = ['assets/js/jquery.validate.min.js'];
        $this->data['breadcrumbs'][] = ['name' => lang('Admin.website_information'), 'url' => '']; // Translated string for "Website Information"
        $this->data['event'] = $this->eventModel->find($id);

        return view('admin/pages/events/edit', $this->data);
    }


    public function update($id)
    {
        $rules = [
            'name' => [
                'label' => lang('Admin.event_message.name_required'),
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Admin.event_message.name_required')
                ]
            ],
            'location' => [
                'label' => lang('Admin.event_message.location_required'),
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Admin.event_message.location_required')
                ]
            ],
            'start_date' => [
                'label' => lang('Admin.event_message.start_date_required'),
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Admin.event_message.start_date_required')
                ]
            ],
            'start_time' => [
                'label' => lang('Admin.event_message.start_time_required'),
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Admin.event_message.start_time_required')
                ]
            ],
            'end_date' => [
                'label' => lang('Admin.event_message.end_date_required'),
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Admin.event_message.end_date_required')
                ]
            ],
            'end_time' => [
                'label' => lang('Admin.event_message.end_time_required'),
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Admin.event_message.end_time_required')
                ]
            ],
            // Uncomment and use this rule if you need to validate the cover upload
            // 'cover' => [
            //     'label' => lang('Admin.event_message.cover_uploaded'),
            //     'rules' => 'uploaded[cover]|max_size[cover,1024]|mime_in[cover,image/jpg,image/jpeg,image/png]',
            //     'errors' => [
            //         'uploaded' => lang('Admin.event_message.cover_uploaded'),
            //         'mime_in' => lang('Admin.event_message.cover_mime_in'),
            //     ]
            // ],
        ];

        if ($this->validate($rules)) {
            $inserted_data = [
                'user_id' => getCurrentUser()['id'],
                'name' => $this->request->getVar('name'),
                'location' => $this->request->getVar('location'),
                'description' => $this->request->getVar('description'),
                'start_date' => $this->request->getVar('start_date'),
                'start_time' => $this->request->getVar('start_time'),
                'end_date' => $this->request->getVar('end_date'),
                'end_time' => $this->request->getVar('end_time'),
                'url' => $this->request->getVar('url'),
            ];
            $avatar  = $this->request->getFile('avatar');
            $cover = $this->request->getFile('cover');

            if (!empty($avatar)) {
                $eventcover = storeMedia($cover, 'cover');
                $inserted_data['cover'] = $eventcover;
            }
            if (!empty($avatar)) {
                $eventavatar = storeMedia($avatar, 'avatar');
                $inserted_data['avatar'] = $eventavatar;
            }

            $this->eventModel->update($id, $inserted_data);

            $this->session->setFlashdata('success', lang('Admin.update_event_success'));
            return redirect('admin/events');
        } else {
            // return redirect('admin/events');
        }
    }


    public function delete($id)
    {

        $this->eventModel->delete($id);
        $this->session->setFlashdata('success', lang('Admin.delete_event_success'));
        return redirect('admin/events');
    }
    public function details($id)
    {
        $this->data['page_title'] = lang('Admin.event_details'); // Translated string for "Event Details"
        $goingeventModel  = new GoingEvent();
        $interestedEvent  = new InterestedEvent();
        $this->data['interestedusers'] = $interestedEvent->getInterested($id);
        $this->data['goingusers'] = $goingeventModel->getGoingUsers($id);
        $this->data['breadcrumbs'][] = ['name' => lang('Admin.website_information'), 'url' => '']; // Translated string for "Website Information"
        $this->data['event'] = $this->eventModel->find($id);
        
        return view('admin/pages/events/details', $this->data);
    }
}
