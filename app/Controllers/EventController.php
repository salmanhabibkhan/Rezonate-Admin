<?php

namespace App\Controllers;


use DateTime;
use App\Models\Event;
use Firebase\JWT\JWT;
use App\Models\PostModel;
use App\Models\UserModel;
use App\Models\GoingEvent;
use App\Models\InterestedEvent;
use CodeIgniter\API\ResponseTrait;
use App\Controllers\BaseController;
use CodeIgniter\RESTful\ResourceController;

class EventController extends BaseController
{
    use ResponseTrait;
    public function addEvent()
    {
        $rules = [
            'name' => [
                'label' => 'Event Name',
                'rules' => 'required|regex_match[/^[a-zA-Z0-9 ]+$/]',
                'errors' => [
                    'required' => lang('Api.name_required'),
                    'regex_match' => lang('Api.name_invalid'),
                ]
            ],
            'location' => [
                'label' => 'Event Location',
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.location_required'),
                ]
            ],
            'start_date' => [
                'label' => 'Start Date',
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.start_date_required'),
                ]
            ],
            'start_time' => [
                'label' => 'Start Time',
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.start_time_required'),
                ]
            ],
            'end_date' => [
                'label' => 'End Date',
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.end_date_required'),
                ]
            ],
            'end_time' => [
                'label' => 'End Time',
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.end_time_required'),
                ]
            ],
        ];
      
        if ($this->validate($rules)) {
            $eventModel = New Event;
            $inserted_data=[
                'user_id'=>getCurrentUser()['id'],
                'name'=>$this->request->getVar('name'),
                'location'=>$this->request->getVar('location'),
                'description'=>$this->request->getVar('description'),
                'start_date'=>$this->request->getVar('start_date'),
                'start_time'=>$this->request->getVar('start_time'),
                'end_date'=>$this->request->getVar('end_date'),
                'end_time'=>$this->request->getVar('end_time'),
                'url'=>$this->request->getVar('url'),
            ];
            $cover = $this->request->getFile('cover');
            if(!empty($cover) &&  $cover->isValid())
            {
                $mediaPath = storeMedia($cover, 'cover');
                $inserted_data['cover'] = $mediaPath;
            }
            if($eventModel->save($inserted_data))
            {
                $inserted_data['is_owner'] = true;
                $inserted_data['is_going'] = true;
                $inserted_data['is_intersted'] = true;
                $inserted_data['id'] = $eventModel->insertID();
                // Create post
                $postModel= New PostModel;
                $postdata=[
                    'user_id'=>getCurrentUser()['id'],
                    'post_text'=> '',
                    'post_type'=>'post',
                    'image_or_video'=>0,
                    'privacy' =>  1,
                    'ip' => $this->request->getIPAddress(),
                    'post_location' =>  '',
                    'post_color_id' =>  0,
                    'width' =>  0,
                    'height' =>  0,
                    'page_id' =>  0,
                    'group_id' =>  0,
                    'event_id' =>  $inserted_data['id'],
                
                ];
                
                $postModel->save($postdata);
                $event = $eventModel->find($inserted_data['id']);
                $compiledEvent = $eventModel->compile_event_data($event);
                return $this->respond([
                    'code' => 200,
                    'message' => lang('Api.event_created_success'),
                    'data' => $compiledEvent
                ], 200);
            }
        } else {
            // Return validation errors
            $validationErrors = $this->validator->getErrors();
            return $this->respond([
                'code' => 400,
                'message' => lang('Api.validation_error'),
                'data' => $validationErrors
            ], 400);
        }
    }
    public function getEvents()
    {
        $rules = [
            'fetch' => 'required',
        ];

        if (!$this->validate($rules)) {
            return $this->respond([
                'code' => '200',
                'message' => 'Invalid Fetch value',
            ], 200);
        }

        $fetch = $this->request->getVar('fetch');

        switch ($fetch) {
            case 'events':
                return $this->fetchEvents();
            case 'interested':
                return $this->fetchInterestedEvents();
            case 'going':
                return $this->fetchGoingEvents();
            case 'myevents':
                return $this->fetchMyEvents();
            default:
                return $this->respond([
                    'code' => '200',
                    'message' => 'Invalid Fetch value',
                ], 200);
        }
    }

    public function getWebEvents()
    {
        $this->data['js_files'] = [];
        $this->data['css_files'] = [];

        $eventModel = new Event;
        $user_id = getCurrentUser()['id'];
        $pager = service('pager');
        $page = (!empty($this->request->getVar('page'))) ? $this->request->getVar('page') : 1;
        
        $today = date('Y-m-d');
        $perPage = 6;
        $totalEvents = $eventModel->where('user_id!=', $user_id)->where('end_date >', $today)->countAllResults();
        
       
        //$events = $eventModel->where('user_id!=', $user_id)->findAll($limit, $offset);
        $events = $eventModel->where('user_id!=', $user_id)->where('end_date >', $today)->orderBy('id','desc')->paginate($perPage);

        foreach ($events as &$event) {
            $event['cover'] = getMedia($event['cover']);
            $event['is_going'] = $eventModel->goingEvent($event['id']);
            $event['is_interested'] = $eventModel->InterestedEvent($event['id']);
        }

        $this->data['pager_links'] = $pager->makeLinks($page, $perPage, $totalEvents, 'socio_custom_pagination');


        $this->data['events'] = $events;
        $this->data['currentPage'] = $page;
    

        echo load_view('pages/events/events', $this->data);
    }


    public function createWebevent()
	{
		$this->data['js_files'] = [];
		$this->data['css_files'] = [];

		echo load_view('pages/events/create-event',$this->data);
	}

    public function editWebevent($event_id)
	{
		$this->data['js_files'] = [];
		$this->data['css_files'] = [];
        $eventModel = new Event;
        $this->data['event'] = $eventModel->where('id',$event_id)->first();
		echo load_view('pages/events/edit-event',$this->data);
	}

    private function fetchEvents()
    {
        $eventModel = new Event;
        $userModel = new UserModel();
        $user_id = getCurrentUser()['id'];
        $offset = (!empty($this->request->getVar('offset'))) ? $this->request->getVar('offset') : 0;
        $limit = (!empty($this->request->getVar('limit'))) ? $this->request->getVar('limit') : 6;
        $today = date('Y-m-d');
        $events = $eventModel->where('user_id!=', $user_id)->where('end_date >', $today)->orderBy('id','desc')->findAll($limit, $offset);

        if (!empty($events)) {
            
            foreach ($events as &$event) {
                $dateTime = new DateTime($event['start_time']);
                $event['start_time'] =$dateTime->format('h:i A'); 
                $dateTime = new DateTime($event['end_time']);
                $event['url'] = site_url('events/event-details/'.$event['id']);
                $event['end_time'] =$dateTime->format('h:i A'); 
                $event['cover'] = getMedia($event['cover']);
                $event['is_owner'] = ($event['user_id'] == $user_id) ? true : false;
                $event['is_interested'] = $this->InterestedEvent($event['id']);
                $event['is_going'] = $this->goingEvent($event['id']);
                $event['userdata'] = $userModel->getUserShortInfo($event['user_id']);

            }
        

            return $this->respond([
                'code' => 200,
                'message' => lang('Api.fetch_events_success'),
                'data' => $events,
            ], 200);
        } else {
            return $this->respond([
                'code' => 200,
                'message' => lang('Api.events_not_found'),
                'data' => [],
            ], 200);
        }
    }

    private function fetchInterestedEvents()
    {
        $interestedEventsModel = new InterestedEvent;
        $userModel = new UserModel();
        $user_id = getCurrentUser()['id'];
        $offset = (!empty($this->request->getVar('offset'))) ? $this->request->getVar('offset') : 0;
        $limit = (!empty($this->request->getVar('limit'))) ? $this->request->getVar('limit') : 6;

        $events = $interestedEventsModel->getInterestedEventsByUserId($user_id, $limit, $offset);

        if (!empty($events)) {
    
            foreach ($events as &$event) {
                $dateTime = new DateTime($event['start_time']);
                $event['start_time'] =$dateTime->format('h:i A'); 
                $dateTime = new DateTime($event['end_time']);
                $event['url'] = site_url('events/event-details/'.$event['id']);
                $event['end_time'] =$dateTime->format('h:i A'); 
                $event['cover'] = getMedia($event['cover']);
                $event['is_owner'] = false;
                $event['is_interested'] = true;
                $event['is_going'] = $this->goingEvent($event['id']);
                $event['userdata'] = $userModel->getUserShortInfo($event['user_id']);
            }

            return $this->respond([
                'code' => 200,
                'message' => lang('Api.fetch_interested_success'),
                'data' => $events,
            ], 200);
        } else {
            return $this->respond([
                'code' => 200,
                'message' => lang('Api.no_interest_events_found'),
                'data' => [],
            ], 200);
        }
    }

    private function fetchGoingEvents()
    {
        $GoingEventModel = new GoingEvent;
        $userModel = new UserModel();
        $user_id = getCurrentUser()['id'];
        $offset = (!empty($this->request->getVar('offset'))) ? $this->request->getVar('offset') : 0;
        $limit = (!empty($this->request->getVar('limit'))) ? $this->request->getVar('limit') : 6;

        $events = $GoingEventModel->getGoingEventsByUserId($user_id, $limit, $offset);

        if (!empty($events)) {
            $modifiedevents = [];
            foreach ($events as &$event) {
                $dateTime = new DateTime($event['start_time']);
                $event['start_time'] =$dateTime->format('h:i A'); 
                $dateTime = new DateTime($event['end_time']);
                $event['url'] = site_url('events/event-details/'.$event['id']);
                $event['end_time'] =$dateTime->format('h:i A'); 
                $event['cover'] =  getMedia($event['cover']);
                $event['is_owner'] = false;
                $event['is_interested'] = $this->InterestedEvent($event['id']);
                $event['is_going'] = true;
                $event['userdata'] = $userModel->getUserShortInfo($event['user_id']);
               
            }

            return $this->respond([
                'code' => 200,
                'message' => lang('Api.fetch_going_success'),
                'data' => $events,
            ], 200);
        } else {
            return $this->respond([
                'code' => 200,
                'message' => lang('Api.going_events_not_found'),
                'data' => [],
            ], 200);
        }
    }

    private function fetchMyEvents()
    {
        $eventModel = new Event;
        $user_id = getCurrentUser()['id'];
        $offset = (!empty($this->request->getVar('offset'))) ? $this->request->getVar('offset') : 0;
        $limit = (!empty($this->request->getVar('limit'))) ? $this->request->getVar('limit') : 6;

        $events = $eventModel->where('user_id', $user_id)->orderBy('id','desc')->findAll($limit, $offset);

        if (!empty($events)) {
            
            foreach ($events as $event) {
                $modifiedevents[] = $eventModel->compile_event_data($event);
            }

            return $this->respond([
                'code' => 200,
                'message' => lang('Api.fetch_my_events_success'),
                'data' => $modifiedevents,
            ], 200);
        } else {
            return $this->respond([
                'code' => 200,
                'message' => lang('Api.my_events_not_found'),
                'data' => [],
            ], 200);
        }
    }

    
    public function createInterest()
    {
        // Define validation rules
        $rules = [
            'event_id' => [
                'label' => 'Event ID',
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.event_id_required'),
                ]
            ]
        ];

        // Validate input
        if (!$this->validate($rules)) {
            return $this->respond([
                'code' => '400',
                'message' => lang('Api.validation_error'),
                'data' => $this->validator->getErrors()
            ], 400);
        }

        $user_id = getCurrentUser()['id'];
        $event_id = esc($this->request->getVar('event_id'));
        $eventInterest = new InterestedEvent();
        $existingInterest = $eventInterest->where(['event_id' => $event_id, 'user_id' => $user_id])->first();

        if (!empty($existingInterest)) {
            $eventInterest->delete($existingInterest['id']);
            return $this->respond([
                'code' => '200',
                'message' => lang('Api.interest_marked_as_not_interested'),
                'interested_status' => "Not Interested"
            ], 200);
        } else {
            $eventInterest->save(['user_id' => $user_id, 'event_id' => $event_id]);
            return $this->respond([
                'code' => '200',
                'message' => lang('Api.interest_marked_as_interested'),
                'interested_status' => "Interested"
            ], 200);
        }
    }

    public function gotoEvent()
    {
        // Define validation rules
        $rules = [
            'event_id' => [
                'label' => 'Event ID',
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.event_id_required'),
                ]
            ]
        ];

        // Validate input
        if (!$this->validate($rules)) {
            return $this->respond([
                'code' => '400',
                'message' => lang('Api.validation_error'),
                'data' => $this->validator->getErrors()
            ], 400);
        }

        $user_id = getCurrentUser()['id'];
        $event_id = esc($this->request->getVar('event_id'));
        $eventGoing = new GoingEvent();
        $existingStatus = $eventGoing->where(['event_id' => $event_id, 'user_id' => $user_id])->first();

        if (!empty($existingStatus)) {
            $eventGoing->delete($existingStatus['id']);
            return $this->respond([
                'code' => '200',
                'message' => lang('Api.going_marked_as_not_going'),
                'going_status' => "Not Going"
            ], 200);
        } else {
            $eventGoing->save(['user_id' => $user_id, 'event_id' => $event_id]);
            return $this->respond([
                'code' => '200',
                'message' => lang('Api.going_marked_as_going'),
                'going_status' => "Going"
            ], 200);
        }
    }

    public function updateEvent()
    {
        // Define validation rules
        $rules = [
            'event_id' => [
                'label' => 'Event ID',
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.event_id_required'),
                ]
            ]
        ];

        // Validate input
        if (!$this->validate($rules)) {
            return $this->respond([
                'code' => '400',
                'message' => lang('Api.validation_error'),
                'data' => $this->validator->getErrors()
            ], 400);
        }

        $id = $this->request->getVar('event_id');
        $event_data = $this->checkEventOwnership($id);

        if ($event_data == 200) {
            $event = new Event();
            $update_data = [];

            // Loop through all input values and add them to the update array
            foreach ($this->request->getPost() as $key => $value) {
                // Exclude the 'event_id' from the update array
                if ($key != 'event_id') {
                    $update_data[$key] = $value;
                }
            }

            // Handle file upload
            $cover = $this->request->getFile('cover');
            if ($cover && $cover->isValid()) {
                $mediaPath = storeMedia($cover, 'cover');
                $update_data['cover'] = $mediaPath;
            }

            if (count($update_data) > 0) {
                $event->update($id, $update_data);
                return $this->respond([
                    'code' => '200',
                    'message' => lang('Api.event_update_success'),
                    'data' => $update_data
                ], 200);
            } else {
                return $this->respond([
                    'code' => '200',
                    'message' => lang('Api.event_update_failure'),
                    'data' => 'No updates were made.'
                ], 200);
            }
        } elseif ($event_data == 401) {
            return $this->respond([
                'code' => '401',
                'message' => lang('Api.not_allowed'),
                'data' => 'failed'
            ], 401);
        } else {
            return $this->respond([
                'code' => '404',
                'message' => lang('Api.event_not_found'),
                'data' => 'not found'
            ], 404);
        }
    }

    public function deleteEvent()
    {
        // Define validation rules
        $rules = [
            'event_id' => [
                'label' => 'Event ID',
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.event_id_required'),
                ]
            ]
        ];

        // Validate input
        if (!$this->validate($rules)) {
            return $this->respond([
                'code' => '400',
                'message' => lang('Api.validation_error'),
                'data' => $this->validator->getErrors()
            ], 400);
        }

        $event_id = $this->request->getVar('event_id');
        $interestedEventsModel = new InterestedEvent();
        $interestedEventsModel->deleteInterestedEvetByEventId($event_id);

        $event_going = new GoingEvent();
        $event_going->deletegoingEvetByEventId($event_id);

        $eventModel = new Event();
        $eventModel->delete($event_id);

        $postModel = new PostModel();
        $postModel->where('event_id', $event_id)->delete();

        return $this->respond([
            'code' => '200',
            'message' => lang('Api.event_deleted_success'),
            'data' => ''
        ], 200);
    }

    public function checkEventOwnership($event_id)
    {
        $user_data = getCurrentUser();
        $model = New Event;
        $event_data = $model->where('id',$event_id)->first();
        
        if(!empty($event_data))
        {
            if($event_data['user_id']==$user_data['id'])
            {
                return 200;
            }
            else{
                return 401;
            }
            
        }
        else{
           return 404;
        }
    }
    public function InterestedEvent($event_id)
    {
        $user_id=  getCurrentUser()['id'];
        $eventInterest = model('InterestedEvent');
        $checkInterest = $eventInterest->where(['event_id'=>$event_id,'user_id'=>$user_id])->first();
        if(!empty($checkInterest))
        {
            return true;
        }
        else{
            return false;
        }
    }


    public function goingEvent($event_id)
    {
        $user_id=  getCurrentUser()['id'];
        $event_going = model('GoingEvent');
        $checgostatus = $event_going->where(['event_id'=>$event_id,'user_id'=>$user_id])->first();
        if(!empty($checgostatus))
        {
            return true;
        }
        else{
            return false;
        }
    }
    public function getMyWebEvents()
    {
        $eventModel = New Event;
        $this->data['user_data'] = getCurrentUser(); 
        $user_id = $this->data['user_data']['id'];
        $page = (!empty($this->request->getVar('page'))) ? $this->request->getVar('page') : 1;
        $limit = (!empty($this->request->getVar('limit'))) ? $this->request->getVar('limit') : 12;
        $offset = ($page - 1) * $limit;
        $totalEvents = $eventModel->where('user_id', $user_id)->countAllResults();
        
        $totalPages = ceil($totalEvents / $limit);
        $this->data['events'] = $eventModel->where('user_id',$this->data['user_data']['id'])->findAll($limit,$offset);
        
        $this->data['currentPage'] = $page;
        $this->data['totalPages'] = $totalPages;
        echo load_view('pages/events/my-events', $this->data); 
        
       
    }
    public function geteventWebDetials($id)
    {
        $eventModel = New Event;
        $interestEventModel = New InterestedEvent;
        $goingevent = New GoingEvent;
        $this->data['user_data'] = getCurrentUser(); 
        $event = $eventModel->find($id);
        
            $this->data['interestedusers'] = $interestEventModel->getInterested($id);
            $this->data['goingusers'] = $goingevent->getGoingUsers($id);
            $this->data['event']  = $event;
            
            echo load_view('pages/events/event-details', $this->data);

    }
 
}
