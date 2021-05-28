<?php

use App\Front\Frontmenu;
use Illuminate\Support\Facades\Crypt;
use App\Http\Models\Notification;
use App\UserSubscription;
use App\GroupFlowerPayment;
use App\AdminGroup;

function makeMenu() {
    $accesmenu = [];
    $userid = Auth::user()->id;
    // $role = DB::select('select role from users WHERE id=' . $userid . '');
    // $permission = DB::select('select permission from tbl_rights WHERE role_id=' . $role[0]->role . '');
    // foreach (json_decode($permission[0]->permission) as $key => $value) {
    //     array_push($accesmenu, $key);
    // }

    $con = request()->route()->getAction();
    $f1 = explode("@", $con['controller']);
    $f2 = explode("Controllers", $f1[0]);
    $controller = strtolower(substr_replace(stripslashes($f2[1]), "", -10));
    $controllername = str_replace("home", "dashboard", $controller);
    $m = DB::select('select * from tbl_menu');
    $menu = json_decode($m[0]->data);
//    echo '<pre>';
//    print_r($menu); die;

    $html = '';
    foreach ($menu as $key => $val) {
        $mcalss = '';
        if (!property_exists($menu[$key], 'children')) {
            if (in_array(strtolower($val->href), $accesmenu)) {
                if (strtolower($val->href) == $controllername) {
                    $mcalss = 'active treeview';
                }
                $html .= '<li class="' . $mcalss . '">
              <a href="' . URL::to('admin') . '/' . strtolower($val->href) . '"> 
              <i class="' . $val->icon . '"></i>
             <span>' . ucfirst($val->text) . '</span>
              </a></li>';
            }
        } else {
            $subm = [];
            $datacount = [];
            foreach ($val->children as $k => $v) {
                array_push($subm, strtolower($v->href));
                if (in_array(strtolower($v->href), $accesmenu)) {
                    array_push($datacount, strtolower($v->href));
                }
            }

            if (in_array($controllername, $subm)) {
                $class = 'active treeview menu-open';
            } else {
                $class = 'treeview';
            }
            if (count($datacount) > 0) {
                $html .= '<li class="' . $class . '">
              <a href="#"> 
             <i class="' . $val->icon . '"></i>
              <span>' . ucfirst($val->text) . '</span>
              <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
              </span>
              </a>
              <ul class="treeview-menu">';
                foreach ($val->children as $k => $v) {
                    if (in_array(strtolower($v->href), $accesmenu)) {
                        $sclass = '';
                        if (strtolower($v->href) == $controllername) {
                            $sclass = 'active';
                        }
                        $html .= '<li class="' . $sclass . '"><a href=' . URL::to('admin') . '/' . strtolower($v->href) . '><i class="fa fa-circle-o"></i> ' . $v->text . ' </a></li>';
                    }
                }

                $html .= '</ul></li>';
            }
        }
    }

    return $html;
}

function ActionButton($id) {


    $con = request()->route()->getAction();
    $f1 = explode("@", $con['controller']);
    $f2 = explode("Controllers", $f1[0]);
    $controller = strtolower(substr_replace(stripslashes($f2[1]), "", -10));
    $controllername = str_replace("home", "dashboard", $controller);

    $action = '';
    // $userid = 1;//Auth::user()->id;
    // $role = 1;//DB::select('select role from users WHERE id=' . $userid . '');
    // $permission = DB::select('select permission from tbl_rights WHERE role_id=1');
    // foreach (json_decode($permission[0]->permission) as $key => $value) {
    //     if ($key == $controllername) {
    //         $action = $value;
    //     }
    // }
    $actionbutton = '';
    // foreach ($action as $k => $v) {
    //     if ($k != 'list') {
    //         $actionbutton .= makeButton($k, $id, $controllername);
    //     }
    // }
    return $actionbutton;
}

function makeButton($btnname, $id, $controllername) {

    switch ($btnname) {
        case "view":
            return ' <a class="btn btn-primary btn-xs" href="' . $controllername . '/view/' . Crypt::encryptString($id) . '" class="text-blue" data-toggle="tooltip" title="View"><i class="fa fa-eye"></i> </a>';
            break;
        case "edit":
            return ' <a class="btn btn-success btn-xs" href="' . $controllername . '/edit/' . Crypt::encryptString($id) . '" class="text-green" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil-square-o"></i> </a>';
            break;
        case "reset":
            return ' <a class="btn btn-warning btn-xs" href="' . $controllername . '/reset/' . Crypt::encryptString($id) . '" class="text-green" data-toggle="tooltip" title="Reset Password"><i class="fa fa-key" aria-hidden="true"></i></a>';
            break;
        case "delete":
            return ' <a class="btn btn-danger btn-xs delete-data text-danger" data-toggle="tooltip" title="Delete" data-delete=' . Crypt::encryptString($id) . '> <i class="fa fa-trash-o"></i> </a>';
            break;
        case "assign":
            return ' <a class="btn btn-warning btn-xs assign-data text-danger" data-toggle="tooltip" title="Assign" data-assign=' . Crypt::encryptString($id) . '> <i class="fa fa-paper-plane" aria-hidden="true"></i> </a>';
            break;
        case "chat":
            return ' <a class="btn btn-success btn-xs chat-data text-danger" data-toggle="tooltip" title="Chat" data-chat=' . Crypt::encryptString($id) . '> <i class="fa fa-envelope" aria-hidden="true"></i> </a>';
            break;
        case "status":
            return ' <a class="btn btn-warning btn-xs status-data text-danger" data-toggle="tooltip" title="Change Status" data-status=' . Crypt::encryptString($id) . '> <i class="fas fa-info-circle"></i> </i> </a>';
            break;
        case "payment":
            return ' <a class="btn btn-info btn-xs payment-data text-danger" data-toggle="tooltip" title="Payment Request" data-payment=' . Crypt::encryptString($id) . '> <i class="fa fa-id-card" aria-hidden="true"></i> </a>';
            break;
        case "email":
            return ' <a class="btn btn-warning btn-xs" href="' . $controllername . '/email/' . Crypt::encryptString($id) . '" class="text-green" data-toggle="tooltip" title="Email"><i class="fa fa-envelope" aria-hidden="true"></i> </a>';
            break;
    }
}

function ActionColumn() {


    $con = request()->route()->getAction();
    $f1 = explode("@", $con['controller']);
    $f2 = explode("Controllers", $f1[0]);
    $controller = strtolower(substr_replace(stripslashes($f2[1]), "", -10));
    $controllername = str_replace("home", "dashboard", $controller);

    $action = '';
    // $userid = Auth::user()->id;
    // $role = DB::select('select role from users WHERE id=' . $userid . '');
    // $permission = DB::select('select permission from tbl_rights WHERE role_id=' . $role[0]->role . '');
    // foreach (json_decode($permission[0]->permission) as $key => $value) {
    //     if ($key == $controllername) {
    //         $action = $value;
    //     }
    // }
    // $column = [];
    // foreach ($action as $k => $v) {
    //     if ($k != 'list' && $k != 'add') {
    //         array_push($column, $v);
    //     }
    // }
    // if (count($column) > 0) {
    //     if (count($column) == 1) {
    //         $width = '5%';
    //     }elseif (count($column) == 2) {
    //         $width = '7%';
    //     } elseif (count($column) == 3) {
    //         $width = '9.5%';
    //     } elseif (count($column) == 4) {
    //         $width = '12%';
    //     } elseif (count($column) == 5) {
    //         $width = '15%';
    //     } elseif (count($column) == 6) {
    //         $width = '17%';
    //     } else {
    //         $width = '10%';
    //     }
    //     return '<th width="' . $width . '">Action</th>';
    // } else {
    //     return FALSE;
    // }
}

function CreateButton() {

    $con = request()->route()->getAction();
    $f1 = explode("@", $con['controller']);
    $f2 = explode("Controllers", $f1[0]);
    $controller = strtolower(substr_replace(stripslashes($f2[1]), "", -10));
    $controllername = str_replace("home", "dashboard", $controller);

    $action = '';
    // $userid = Auth::user()->id;
    // $role = DB::select('select role from users WHERE id=' . $userid . '');
    // $permission = DB::select('select permission from tbl_rights WHERE role_id=' . $role[0]->role . '');
    // foreach (json_decode($permission[0]->permission) as $key => $value) {
    //     if ($key == $controllername) {
    //         $action = $value;
    //     }
    // }
//    echo '<pre>';
//    print_r($action);
//    die;
//    if($controllername=='applicationstatus'){
//        $controllername = 'Application Status';
//    }
    if (property_exists($action, 'add')) {
        return '<div class="clearfix cbutton">
        <div class="pull-right">
           <a href=' . $controllername . '/create' . '><button class="btn btn-success btn-flat" data-toggle="tooltip" title="Create ' . ucfirst($controllername) . '">Create ' . ($controllername == 'applicationstatus' ? 'Application Status' : ucfirst($controllername)) . '</button></a>
        </div> 
   </div>';
    } else {
        return FALSE;
    }
}

function ExportButton() {

    $con = request()->route()->getAction();
    $f1 = explode("@", $con['controller']);
    $f2 = explode("Controllers", $f1[0]);
    $controller = strtolower(substr_replace(stripslashes($f2[1]), "", -10));
    $controllername = str_replace("home", "dashboard", $controller);

    $action = '';
    $userid = Auth::user()->id;
    $role = DB::select('select role from users WHERE id=' . $userid . '');
    $permission = DB::select('select permission from tbl_rights WHERE role_id=' . $role[0]->role . '');
    foreach (json_decode($permission[0]->permission) as $key => $value) {
        if ($key == $controllername) {
            $action = $value;
        }
    }
//    echo '<pre>';
//    print_r($action);
//    die;
//    if($controllername=='applicationstatus'){
//        $controllername = 'Application Status';
//    }
    if (property_exists($action, 'report')) {
        return '<button type="button" id="report" class="btn btn-danger btn-flat"><i class="fa fa-file-pdf-o" aria-hidden="true"></i>  Export Report</button>';
    } else {
        return FALSE;
    }
}

function Get_Frontmenu($parent_id) {

    $menu = "";
    $data = App\Front\Frontmenu::where('parent_id', $parent_id)->get();

    foreach ($data as $val) {

        $menu .= "<li><a href=" . URL::to('/' . $val->link) . ">" . $val->name . "</a>";
//        $menu .= "<ul>" . Get_Frontmenu($val->id) . "</ul>"; //call  recursively
        $menu .= "</li>";
    }
    return $menu;
}

function menucount($id) {
    $data = DB::select('select * from tbl_fmenu WHERE parent_id=' . $id . '');

    if (count($data) > 0) {
        $d = DB::select('select * from tbl_fmenu WHERE id=' . $id . '');

        if ($d[0]->parent_id == '0') {
            $class = 'icon-angle-down';
        } else {
            $class = 'icon-angle-right';
        }
    } else {
        $class = '';
    }
    return $class;
}

function levelclass($id) {
    $data = DB::select('select * from tbl_fmenu WHERE parent_id=' . $id . '');

    if (count($data) > 0) {
        $d = DB::select('select * from tbl_fmenu WHERE id=' . $id . '');

        if ($d[0]->parent_id == '0') {
            $class = 'dropdown-menu';
        } else {
            $class = 'dropdown-menu sub-menu-level1';
        }
    } else {
        $class = 'dropdown-menu';
    }
    return $class;
}

function language() {
    $html = '';
    $ldata = DB::select('select * from tbl_language WHERE status="0"');
    foreach ($ldata as $lval) {
        $html .= " <li><a href='" . url('locale/' . $lval->slug) . "'>" . $lval->title . "</a></li>";
    }
    return $html;
}

function dataView($data, $exclude = NULL, $file = NULL) {
    // echo "<pre>";print_r($data);die;
    if (empty($file)) {
        $file = [];
    }
    if (empty($exclude)) {
        $exclude = [];
    }

    $i = 1;
    $html = '<table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="width: 4%">#</th>
                        <th style="width: 25%">Title</th>
                        <th>Description</th>

                    </tr>
                </thead>';
    foreach ($data as $key => $value) {
        if (in_array($key, $file)) {
            $value = ($value == '' ? 'N/A' : '<a href=' . url('/') . '/' . $value . ' target="_blank"><button class="btn btn-danger btn-xs" data-toggle="tooltip" title="Download"><i class="fa fa-download"></i></button></a>');
        }
        if (!in_array($key, $exclude)) {
            $keys = str_replace(array('_'), array(' '), $key);
            $html .= '<tr>
                        <td>' . $i . '</td>
                        <td>' . ucwords($keys) . '</td>
                        <td>' . (strtolower($key) == 'status' ? ($value == '1' ? '<span class="label label-success">Active</span>' : '<span class="label label-danger">In-Active</span>') : ($value == '' ? 'N/A' : $value)) . '</td>

                    </tr>';
            $i++;
        }
    }
    $html .= '</table>';

    return $html;
}

/* * * Get User details */

function userDetails($id = null) {
    $userDetails = [];
    $userDetails = DB::table('users')->where(array('id' => $id))->first();

    return $userDetails;
}

function sendNotification($data = array(), $sendPush = 1) {


    if (!empty($data)) {
        $notification = $data;
        $isSaved = Notification::create($notification);
        // $isSaved = DB::table('notifications')->insert($notification);

        /* if($sendPush == 1 && $isSaved) {
          $devices = $userDevicesTable->find('all', [
          'conditions' => [
          'UserDevices.user_id' => $data['send_to'],
          'UserDevices.status' => 1,
          'UserDevices.device_type <>' => '',
          'UserDevices.device_type IS NOT NULL',
          'UserDevices.device_token <>' => '',
          'UserDevices.device_token IS NOT NULL'
          ]
          ])->all();

          if(!empty($devices)) {
          // Count Unread Notifications Start
          $options = [
          'fields'=> ['Notifications.id'],
          'conditions'=> ['Notifications.send_to'=> $data['send_to'], 'Notifications.is_read'=> 0],
          'group'=> ['Notifications.send_to'],
          ];
          $countNotifications = $notificationsTable->find('all', $options)->count();
          // Count Unread Notifications End

          $data['notification_count'] = $countNotifications;

          $android = $ios = array();
          foreach($devices as $device) {
          if($device['UserDevice']['device_type'] == 'android') {
          $android[] = $device['UserDevice']['device_token'];
          } else if($device['UserDevice']['device_type'] == 'ios') {
          $ios[] = $device['UserDevice']['device_token'];
          }
          }

          if(!empty($android)) {
          $this->sendNotificationAndroid($android, $data);
          }
          if(!empty($ios)) {
          $this->sendNotificationIOS($ios, $data);
          }
          }
          } */

        return $isSaved;
    }
    return false;
}

function getTopNotifications($loggedInUser = null) {
    $result = [
        'unreadNotification' => 0,
        'notifications' => array()
    ];

    if (!empty($loggedInUser)) {

        $notifications = DB::table('notifications')
                ->join('users', 'users.id', '=', 'notifications.send_by')
                ->leftJoin('group_flowers as gf', 'gf.id', '=', 'notifications.group_flower_id')
                ->select('notifications.*')
                ->where(array('notifications.send_to' => $loggedInUser, 'users.status' => 1, 'notifications.is_read' => 0))
                ->groupBy('notifications.id')
                ->get();

        $result['unreadNotification'] = $notifications->count();
    }

    return $result;
}

/** Get subscription plan of user - 0:Not Subscribed, 1: Subscribed */
function getUserSubscriptionDetails($loggedInUser = null) {

    $result = [
        'is_subscribed' => 0,
        'text' => 'Please buy a subscription plan',
        'balanceDay' => 0,
    ];

    // $myPlan = DB::select("select * from tbl_user_subscriptions WHERE user_id = $loggedInUser AND payment_status =1 ORDER BY created_at DESC LIMIT 1");

    $myPlan = UserSubscription::where(array('user_id' => $loggedInUser, 'payment_status' => 1))->orderBy('payment_date', 'DESC')->limit(1)->first();

    if (!empty($myPlan)) {
        $buyDate = $myPlan->payment_date;
        $planType = $myPlan->subscription_type;
        if ($planType == 1 || $planType == 3) {
            $expiryDate = date("Y-m-d H:i:s", strtotime('+30 days', strtotime($buyDate)));
            $balanceDay = round((strtotime($expiryDate) - strtotime(date("Y-m-d H:i:s"))) / (60 * 60 * 24));
        } else if ($planType == 2 || $planType == 4) {
            $expiryDate = date("Y-m-d H:i:s", strtotime('+365 days', strtotime($buyDate)));
            $balanceDay = round((strtotime($expiryDate) - strtotime(date("Y-m-d H:i:s"))) / (60 * 60 * 24));
        }

        if ($balanceDay > 0) {
            $balanceDay = $balanceDay;
            $result = [
                'is_subscribed' => 1,
                'text' => 'Your subscription will finish in ' . $balanceDay . ' Days',
                'balanceDay' => $balanceDay,
            ];
        } else {
            $balanceDay = 0;
            $result = [
                'is_subscribed' => 1,
                'text' => 'Subscription plan expired',
                'balanceDay' => $balanceDay,
            ];
        }
    }

    return $result;
}

/** Get subscription plan of user - 0:Not Subscribed, 1: Subscribed */
function getFlowerPlanDetails($loggedInUser = null) {

    $result = [
        'is_flower_plan' => 0,
        'flower_plan_details' => array(),
    ];
    DB::enableQueryLog();
    $myFlowerPlan = GroupFlowerPayment::select('id')->where('user_id', '=', $loggedInUser)
                    ->whereNotExists(
                            function($query) {
                        $query->select(DB::raw('id'))
                        ->from('group_flowers')
                        ->whereRaw('group_flowers.payment_id = group_flower_payments.id');
                    }
                    )->first();
    // dd(DB::getQueryLog());
    if (!empty($myFlowerPlan)) {
        $result = [
            'is_flower_plan' => 1,
            'flower_plan_details' => $myFlowerPlan,
        ];
    }

    return $result;
}

/** Get subscription plan of user - 0:Not Subscribed, 1: Subscribed */
function generateUniqueGroupFlowerId() {
    $obj = new AdminGroup();
    do {
        $uniqueNumber = "LOADUS" . mt_rand(10000000, 99999999); // Generate your key here...
    } while (!empty(AdminGroup::where('group_flower_unique_id', "$uniqueNumber")->first()));

    return $uniqueNumber;
        
}

function isUserExists($email = null){

    $userDetails = [];
    $userDetails = DB::table('users')->where(array('email'=>$email))->first();
    
    return $userDetails;
}

?>
