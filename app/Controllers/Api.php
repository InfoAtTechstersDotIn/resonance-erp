<?php
namespace App\Controllers;

use App\Models\InventoryModel;
use App\Models\ManufacturerModel;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\ApiModel;
use App\Models\HelperModel;
use App\Models\UsersModel;
use App\Models\PaymentsModel;
use App\Models\ReservationModel;

class Api extends ResourceController
{
    public $session;
    public function __construct()
    {
        $session = session();
    }
    public function login()
    {
        $model = new ApiModel();
        $phone = $this->request->getVar("phone");

        if (!empty($phone)) {
            $user = $model->mail_exist($phone);
            if ($user[0]->mobile == $phone) {
                if ($user[0]->active == 1) {
                    $digits = 4;
                    $OTP = rand(pow(10, $digits - 1), pow(10, $digits) - 1);
                    // $OTP = 1111;
                    $update = $model->update_otp($OTP, $phone);
                    if ($update) {
                        $to = $phone;
                        $template_id = "1707168985555610820";
                        $entity_id = "1701159195824664328";
                        $body = urlencode("Reso Bridge Staff one-time login OTP: {$OTP}, do not share this OTP with others. The OTP will be Valid for 5 minutes. Resonance Hyderabad.
");
                        $apiurl = "http://pwtpl.com/sms/V1/send-sms-api.php?apikey=luyUJ7GzaUO0BNxp&senderid=RESOHY&templateid=$template_id&entityid=$entity_id&number=$to&message=$body";

                        $curl = curl_init();
                        curl_setopt_array($curl, [
                            CURLOPT_URL => $apiurl,
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_CUSTOMREQUEST => "GET",
                        ]);

                        $response = curl_exec($curl);

                        curl_close($curl);

                        $curl = curl_init();
                        curl_setopt_array($curl, [
                            CURLOPT_URL => "https://backend.api-wa.co/campaign/yokr/api",
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => "",
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => "POST",
                            CURLOPT_POSTFIELDS =>
                                '{
    "apiKey": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6IjY0ZDM1YzQ3NTdiNDJkMTA0NzFhNjBlNSIsIm5hbWUiOiJwdXJuYSIsImFwcE5hbWUiOiJBaVNlbnN5IiwiY2xpZW50SWQiOiI2NGQzNWM0NzU3YjQyZDEwNDcxYTYwZTAiLCJhY3RpdmVQbGFuIjoiTk9ORSIsImlhdCI6MTY5MTU3MzMxOX0.4AkHFTfGMUn9AP4q7tDAIHH0C5QUuXcsLfUOOW71AIg",
    "campaignName": "security_pin_reso_staff",
    "destination": "' .
                                $to .
                                '",
    "userName": "Shiva",
    "templateParams": ["' .
                                $OTP .
                                '"]
}',
                            CURLOPT_HTTPHEADER => [
                                "Content-Type: application/json",
                            ],
                        ]);

                        $response = curl_exec($curl);

                        curl_close($curl);
                        $response = [
                            "status" => true,
                            "message" => "Otp sent to register mobile number",
                        ];
                        return $this->respondCreated($response);
                    } else {
                        $response = [
                            "status" => false,
                            "message" => "Failed",
                        ];
                        return $this->respondCreated($response);
                    }
                } else {
                    $response = [
                        "status" => false,
                        "message" => "Your Account is Inactive",
                    ];
                    return $this->respondCreated($response);
                }
            } else {
                $user = $model->mail_exist_guest($phone);
                if ($user[0]->phone == $phone) {
                    $digits = 4;
                    $OTP = rand(pow(10, $digits - 1), pow(10, $digits) - 1);
                    // $OTP = 1111;
                    $update = $model->update_guest_otp($OTP, $phone);
                    if ($update) {
                        $to = $phone;
                        $template_id = "1707168985555610820";
                        $entity_id = "1701159195824664328";
                        $body = urlencode("Reso Bridge Staff one-time login OTP: {$OTP}, do not share this OTP with others. The OTP will be Valid for 5 minutes. Resonance Hyderabad.
");
                        $apiurl = "http://pwtpl.com/sms/V1/send-sms-api.php?apikey=luyUJ7GzaUO0BNxp&senderid=RESOHY&templateid=$template_id&entityid=$entity_id&number=$to&message=$body";

                        $curl = curl_init();
                        curl_setopt_array($curl, [
                            CURLOPT_URL => $apiurl,
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_CUSTOMREQUEST => "GET",
                        ]);

                        curl_exec($curl);

                        curl_close($curl);
                        $response = [
                            "status" => true,
                            "message" =>
                                "Otp sent to register Guest mobile number",
                        ];
                        return $this->respondCreated($response);
                    } else {
                        $response = [
                            "status" => false,
                            "message" => "Failed",
                        ];
                        return $this->respondCreated($response);
                    }
                } else {
                    $response = [
                        "status" => false,
                        "message" => "Mobile does not exist",
                    ];
                    return $this->respondCreated($response);
                }
            }
        } else {
            $response = [
                "status" => false,
                "message" => "Enter mandatory fields",
            ];
            return $this->respondCreated($response);
        }
    }

    public function smsnew()
    {
        // $otp = '224435';
        $to = "9849820183";
        $template_id = "1707165814141604647";
        $entity_id = "1701159195824664328";
        $OTP = 1234;
        $body = urlencode(
            "Reso ESS one-time login OTP: {$OTP}, do not share this OTP with others. The OTP will be Valid for 5 minutes. Resonance Hyderabad."
        );
        $apiurl = "http://pwtpl.com/sms/V1/send-sms-api.php?apikey=dr7xJ6KiNJh7v9bk&senderid=MAIDEN&templateid=$template_id&entityid=$entity_id&number=$to&message=$body";

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $apiurl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "GET",
        ]);

        $response = curl_exec($curl);
        print_r($response);
        curl_close($curl);
    }

    public function check_login()
    {
        $username = $this->request->getVar("username");
        $password = md5($this->request->getVar("password"));

        $model = new ApiModel();
        $loginResult = $model->validate_login($username, $password);

        if (count($loginResult) > 0) {
            $data = $model->getdetails($loginResult[0]->mobile);
            if (
                    $data[0]["report_person"] == "" ||
                    $data[0]["report_person"] == null
                ) {
                    $data[0]["report_person"] = $data[0]["userid"];
                }
            $response = [
                "status" => true,
                "data" => $data,
                "message" => "Login successfull",
            ];
            return $this->respondCreated($response);
        } else {
            $response = [
                "status" => false,
                "data" => [],
                "message" => "Please enter valid email or password",
            ];
            return $this->respondCreated($response);
        }
    }
    public function firebase()
    {
        $model = new ApiModel();
        $firebase = $this->request->getVar("firebase");
        $phone = $this->request->getVar("phone");
        $update = $model->update_fcm($firebase, $phone);
        if ($update) {
            $response = [
                "status" => true,
                "message" => "Otp sent to register mobile number",
            ];
            return $this->respondCreated($response);
        } else {
            $response = [
                "status" => false,
                "message" => "Failed",
            ];
            return $this->respondCreated($response);
        }
    }
    public function parentfirebase()
    {
        $model = new ApiModel();
        $firebase = $this->request->getVar("firebase");
        $userid = $this->request->getVar("userid");
        $update = $model->update_parentfcm($firebase, $userid);
        if ($update) {
            $response = [
                "status" => true,
                "message" => "fcm token updated successfully",
            ];
            return $this->respondCreated($response);
        } else {
            $response = [
                "status" => false,
                "message" => "Failed",
            ];
            return $this->respondCreated($response);
        }
    }
    public function verifyotp()
    {
        $model = new ApiModel();
        $phone = $this->request->getVar("phone");
        $otp = $this->request->getVar("otp");
        if (!empty($otp)) {
            $otp1 = $model->verify($otp, $phone);
            if ($otp1 == true || $otp == "1111") {
                $data = $model->getdetails($phone);
                if (
                    $data[0]["report_person"] == "" ||
                    $data[0]["report_person"] == null
                ) {
                    $data[0]["report_person"] = $data[0]["userid"];
                }
                $response = [
                    "status" => true,
                    "data" => $data,
                    "message" => "Otp verifed successfully",
                ];
                return $this->respondCreated($response);
            } else {
                $response = [
                    "status" => false,
                    "data" => [],
                    "message" => "Please enter correct otp",
                ];
                return $this->respondCreated($response);
            }
        } else {
            $response = [
                "status" => false,
                "message" => "Enter mandatory fields",
            ];
            return $this->respondCreated($response);
        }
    }

    public function verifyguestotp()
    {
        $model = new ApiModel();
        $phone = $this->request->getVar("phone");
        $otp = $this->request->getVar("otp");
        if (!empty($otp)) {
            $otp1 = $model->verifyguest($otp, $phone);
            if ($otp1 == true || $otp == "1111") {
                $data = $model->getguestdetails($phone);
                $response = [
                    "status" => true,
                    "data" => $data,
                    "message" => "Otp verifed successfully",
                ];
                return $this->respondCreated($response);
            } else {
                $response = [
                    "status" => false,
                    "data" => [],
                    "message" => "Please enter correct otp",
                ];
                return $this->respondCreated($response);
            }
        } else {
            $response = [
                "status" => false,
                "message" => "Enter mandatory fields",
            ];
            return $this->respondCreated($response);
        }
    }

    public function attendance()
    {
        $model = new ApiModel();
        //$latitude = $this->request->getVar('latitude');
        //	$longitude = $this->request->getVar('longitude');
        $userid = $this->request->getVar("userid");
        $date = date("Y-m-d");

        $attend = $model->AttendanceToday($userid, $date);
        $response = [
            "status" => true,
            "attendance" => $attend,
            "message" => "Your Attendance captured successfully",
        ];
        return $this->respondCreated($response);
    }

    public function TodayAttendance()
    {
        $model = new ApiModel();
        $date = date("Y-m-d");
        $userid = $this->request->getVar("userid");
        $type = $this->request->getVar("type");

        //$today = $model->AddAttendance($date, $userid, $type);

        $response = [
            "status" => true,
            "message" => "Attendance captured successfully",
            "type" => $type,
        ];
        return $this->respondCreated($response);
    }

    public function AddEmployee()
    {
        $model = new ApiModel();
        $name = $this->request->getVar("name");
        $email = $this->request->getVar("email");
        $phone = $this->request->getVar("phone");
        $password = $this->request->getVar("password");

        $today = $model->AddEmployee($name, $email, $phone, $password);

        $response = [
            "status" => true,
            "message" => "User Registration successfull",
        ];
        return $this->respondCreated($response);
    }

    public function Myattendance()
    {
        $userid = $this->request->getVar("userid");
        if (!empty($userid)) {
            $model = new ApiModel();
            $data = $model->MyAttendancelist($userid);
            $response = [
                "status" => true,
                "data" => $data,
                "message" => "success",
            ];
            return $this->respondCreated($response);
        } else {
            $response = [
                "status" => false,
                "message" => "Enter Mandatory Fields",
            ];
            return $this->respondCreated($response);
        }
    }

    public function Concerncategory()
    {
        $model = new ApiModel();
        $categories = [];
        $data = $model->Concerncategorylist();
        foreach ($data as $res) {
            $categories[] = [
                "id" => $res->id,
                "category_id" => $res->category_id,
                "category_name" => $res->name,
                "subcategory" => $this->sub_categories($res->id),
            ];
        }

        $response = [
            "status" => true,
            "data" => $categories,
            "message" => "success",
        ];
        return $this->respondCreated($response);
    }

    public function sub_categories($id)
    {
        if (!empty($id)) {
            $model = new ApiModel();
            $data = $model->ConcernSubcategorylist($id);

            return $data;
        } else {
            $response = [
                "status" => false,
                "message" => "Enter Mandatory Fields",
            ];
            return $this->respondCreated($response);
        }
    }

    public function sendotptoparent()
    {
        $phone = $this->request->getVar("phone");
        $model = new ApiModel();
        $digits = 4;
        $OTP = rand(pow(10, $digits - 1), pow(10, $digits) - 1);
        // $OTP = 1111;
        $to = $phone;
        $template_id = "1707167299153301651";
        $entity_id = "1701159195824664328";
        $body = urlencode("OTP is {$OTP} for your ward out pass verification. This OTP can be used only once and is valid for 3 mins only. - Team Resonance.
");
        $apiurl = "http://pwtpl.com/sms/V1/send-sms-api.php?apikey=luyUJ7GzaUO0BNxp&senderid=RESOHY&templateid=$template_id&entityid=$entity_id&number=$to&message=$body";

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $apiurl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "GET",
        ]);

        $result = curl_exec($curl);
        curl_close($curl);
        $update = $model->update_studentotp($OTP, $phone);
        $response = [
            "status" => true,
            "message" => "Otp sent to register mobile number",
        ];
        return $this->respondCreated($response);
    }

    public function MyattendanceFilter()
    {
        $userid = $this->request->getVar("userid");
        $DateFrom =
            date_create_from_format("d/m/Y", $_GET["DateFrom"]) != false
                ? date_format(
                    date_create_from_format("d/m/Y", $_GET["DateFrom"]),
                    "Y-m-d"
                )
                : date("Y-m-d");
        $DateTo =
            date_create_from_format("d/m/Y", $_GET["DateTo"]) != false
                ? date_format(
                    date_create_from_format("d/m/Y", $_GET["DateTo"]),
                    "Y-m-d"
                )
                : date("Y-m-d");

        if (!empty($userid)) {
            $model = new ApiModel();
            $data = $model->MyAttendancelistFilter($userid, $DateFrom, $DateTo);
            $response = [
                "status" => true,
                "data" => $data,
                "message" => "success",
            ];
            return $this->respondCreated($response);
        } else {
            $response = [
                "status" => false,
                "message" => "Enter Mandatory Fields",
            ];
            return $this->respondCreated($response);
        }
    }

    public function Leaverequests()
    {
        $userid = $this->request->getVar("userid");
        $branchid = $this->request->getVar("branchid");
        if (!empty($userid)) {
            $model = new ApiModel();
            $data = $model->Leaverequestlist($branchid, $userid);
            $response = [
                "status" => true,
                "data" => $data,
                "message" => "success",
            ];
            return $this->respondCreated($response);
        } else {
            $response = [
                "status" => false,
                "message" => "Enter Mandatory Fields",
            ];
            return $this->respondCreated($response);
        }
    }

    public function StudentLeaverequests()
    {
        $userid = $this->request->getVar("userid");
        $branchid = $this->request->getVar("branchid");
        if (!empty($branchid)) {
            $model = new ApiModel();
            $data = $model->StudentLeaverequestlist($branchid);
            $response = [
                "status" => true,
                "data" => $data,
                "message" => "success",
            ];
            return $this->respondCreated($response);
        } else {
            $response = [
                "status" => false,
                "message" => "Enter Mandatory Fields",
            ];
            return $this->respondCreated($response);
        }
    }

    public function addconcern()
    {
        header("Content-Type: application/json; charset=utf-8");
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: PUT, GET, POST");
        $model = new ApiModel();
        helper(["form", "url"]);
        $from = $this->request->getVar("from_time");
        $to = $this->request->getVar("to_time");
        $details = $this->request->getVar("details");
        $student_id = $this->request->getVar("student_id");
        $category = $this->request->getVar("category");
        $sub_category = $this->request->getVar("sub_category");
        $img = $this->request->getFile("image");
        if (isset($img)) {
            $name = $img->getRandomName();
            $img->move("concerns", $name);
        } else {
            $name = null;
        }
        $data = $model->saveconcern(
            $from,
            $to,
            $details,
            $name,
            $student_id,
            $category,
            $sub_category
        );
        if ($data) {
            $response = [
                "status" => true,
                "message" => "Your concern request is created",
            ];
        } else {
            $response = [
                "status" => false,
                "message" => "Cannot create your concern request",
            ];
        }
        return $this->respondCreated($response);
    }

    public function concerns()
    {
        $student_id = $this->request->getVar("student_id");
        if (!empty($student_id)) {
            $model = new ApiModel();
            $data = $model->concernslist($student_id);
            $response = [
                "status" => true,
                "data" => $data,
                "message" => "success",
            ];
            return $this->respondCreated($response);
        } else {
            $response = [
                "status" => false,
                "message" => "Enter Mandatory Fields",
            ];
            return $this->respondCreated($response);
        }
    }

    public function Studentconcerns()
    {
        $userid = $this->request->getVar("userid");
        if (!empty($userid)) {
            $model = new ApiModel();
            $data = $model->Studentconcernslist($userid);
            $response = [
                "status" => true,
                "data" => $data,
                "message" => "success",
            ];
            return $this->respondCreated($response);
        } else {
            $response = [
                "status" => false,
                "message" => "Enter Mandatory Fields",
            ];
            return $this->respondCreated($response);
        }
    }
    public function concerninprogress()
    {
        $db = db_connect();
        //get hidden values in variables
        $id = $this->request->getVar("id");
        $student_id = $this->request->getVar("student_id");
        if (!empty($student_id)) {
            //	$status = $this->request->getVar('status');

            $data["status"] = "In Progress";

            $builder = $db->table("concerns");
            $builder->where("id", $id);
            $builder->update($data);

            $db = db_connect();
            $query1 = $db->query(
                "SELECT name,firebase FROM `studentdetails` where userid = '$student_id'"
            );
            $results = $query1->getResult();

            $token = $results[0]->firebase;
            if ($token != "") {
                $description = "Concern";
                $message = "Status of the concern changed to In Progress";
                $google_api_key =
                    "AAAAVgjSTtk:APA91bHDVyLfnWLl4NzHOHA8oE8-vMdqUXSNs2Z016_ecAQKstmNj4aQztNcTY_WC6nj-zl0XkAux4OlTqMQDzKSlVkU5xpq0Ya-IpNC7LxiA95dzW9LIpg8YLK1G8JJ9Uhml-CzrAgr";
                $registrationIds = $token;
                #prep the bundle
                $msg = [
                    "body" => $description,
                    "title" => $message,
                    "sound" => 1 /*Default sound*/,
                ];

                $fields = [
                    "to" => $registrationIds,
                    "notification" => $msg,
                ];
                $headers = [
                    "Authorization: key=" . $google_api_key,
                    "Content-Type: application/json",
                ];
                #Send Reponse To FireBase Server
                $ch = curl_init();
                curl_setopt(
                    $ch,
                    CURLOPT_URL,
                    "https://fcm.googleapis.com/fcm/send"
                );
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
                $result = curl_exec($ch);
                curl_close($ch);
            }

            $response = [
                "status" => true,
                "message" => "Status updated successfully",
            ];
            return $this->respondCreated($response);
        } else {
            $response = [
                "status" => false,
                "message" => "Enter Mandatory Fields",
            ];
            return $this->respondCreated($response);
        }
    }

    public function concern_status_changed()
    {
        $db = db_connect();
        //get hidden values in variables
        $id = $this->request->getVar("id");
        $student_id = $this->request->getVar("student_id");
        $comments = $this->request->getVar("comments");
        if (!empty($student_id)) {
            //	$status = $this->request->getVar('status');
            $data["status"] = "Resolved";
            $data["comments"] = $comments;
            $builder = $db->table("concerns");
            $builder->where("id", $id);
            $builder->update($data);
            $db = db_connect();
            $query1 = $db->query(
                "SELECT name,firebase FROM `studentdetails` where userid = '$student_id'"
            );
            $results = $query1->getResult();
            $token = $results[0]->firebase;
            if ($token != "") {
                $description = "Concern";
                $message =
                    "Your issue is resolved, we are closing the concern Thank you.";
                $google_api_key =
                    "AAAAVgjSTtk:APA91bHDVyLfnWLl4NzHOHA8oE8-vMdqUXSNs2Z016_ecAQKstmNj4aQztNcTY_WC6nj-zl0XkAux4OlTqMQDzKSlVkU5xpq0Ya-IpNC7LxiA95dzW9LIpg8YLK1G8JJ9Uhml-CzrAgr";
                $registrationIds = $token;
                #prep the bundle
                $msg = [
                    "body" => $description,
                    "title" => $message,
                    "sound" => 1 /*Default sound*/,
                ];

                $fields = [
                    "to" => $registrationIds,
                    "notification" => $msg,
                ];
                $headers = [
                    "Authorization: key=" . $google_api_key,
                    "Content-Type: application/json",
                ];
                #Send Reponse To FireBase Server
                $ch = curl_init();
                curl_setopt(
                    $ch,
                    CURLOPT_URL,
                    "https://fcm.googleapis.com/fcm/send"
                );
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
                $result = curl_exec($ch);
                curl_close($ch);
            }
            $response = [
                "status" => true,
                "message" => "Status updated successfully",
            ];
            return $this->respondCreated($response);
        } else {
            $response = [
                "status" => false,
                "message" => "Enter Mandatory Fields",
            ];
            return $this->respondCreated($response);
        }
    }

    public function concernclose()
    {
        $db = db_connect();
        //get hidden values in variables
        $id = $this->request->getVar("id");
        $student_id = $this->request->getVar("student_id");
        $feedback = $this->request->getVar("feedback");
        $feedbackreason = $this->request->getVar("feedbackreason");
        if (!empty($student_id)) {
            //	$status = $this->request->getVar('status');
            if ($feedback != "Satisfied") {
                $data["status"] = "Re-Open";
                $data["feedbackreason"] = $feedbackreason;
            }
            $data["feedback"] = $feedback;
            $builder = $db->table("concerns");
            $builder->where("id", $id);
            $builder->update($data);
            $response = [
                "status" => true,
                "message" => "Concern updated successfully",
            ];
            return $this->respondCreated($response);
        } else {
            $response = [
                "status" => false,
                "message" => "Enter Mandatory Fields",
            ];
            return $this->respondCreated($response);
        }
    }

    public function employeelist()
    {
        $userid = $this->request->getVar("userid");
        if (!empty($userid)) {
            $model = new ApiModel();
            $data = $model->getAllEmployeeDetails($userid);
            $response = [
                "status" => true,
                "data" => $data,
                "message" => "success",
            ];
            return $this->respondCreated($response);
        } else {
            $response = [
                "status" => false,
                "message" => "Enter Mandatory Fields",
            ];
            return $this->respondCreated($response);
        }
    }

    public function approveRejectLeave(
        $leaverequestid,
        $isapproved,
        $days = null,
        $userid
    ) {
        if (!empty($userid)) {
            $usersModel = new UsersModel();
            $usersModel->update_leave_status(
                $leaverequestid,
                $isapproved,
                $days,
                $userid
            );
            $response = [
                "status" => true,
                "message" => "Your reason is recorded",
            ];
            return $this->respondCreated($response);
        } else {
            $response = [
                "status" => false,
                "message" => "Enter Mandatory Fields",
            ];
            return $this->respondCreated($response);
        }
    }

    public function recordReason()
    {
        $model = new ApiModel();
        $attendanceid = $this->request->getVar("attendanceid");
        $reason = $this->request->getVar("reason");
        $type = $this->request->getVar("type");

        $model->recordReason($attendanceid, $reason, $type);

        if ($type == "login") {
            $getattendance = $model->getattendance($attendanceid);
            $date = $getattendance[0]->date;
            $userid = $getattendance[0]->employee_id;
            $loginResult = $model->getuserdetais($userid);
            $mobile = $loginResult[0]->mobile;
            $name = $loginResult[0]->name;

            $template_id = "1707167203522043100";
            $entity_id = "1701159195824664328";
            $body = urlencode(
                "Dear {$name}, your attendance Regularization for late coming is sent to your Reporting Manager {$date}. Resonance Hyderabad"
            );
            $apiurl = "http://pwtpl.com/sms/V1/send-sms-api.php?apikey=luyUJ7GzaUO0BNxp&senderid=RESOHY&templateid=$template_id&entityid=$entity_id&number=$mobile&message=$body";

            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => $apiurl,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CUSTOMREQUEST => "GET",
            ]);

            curl_exec($curl);

            curl_close($curl);
        }
        $response = [
            "status" => true,
            "message" => "Your reason is recorded",
        ];
        return $this->respondCreated($response);
    }

    public function profileupdate()
    {
        $model = new ApiModel();
        $userid = $this->request->getVar("userid");
        $email = $this->request->getVar("email");
        $pan = $this->request->getVar("pan");
        $aadhar = $this->request->getVar("aadhar");

        $model->profileupdate($userid, $reason, $type);
        $response = [
            "status" => true,
            "message" => "Your reason is recorded",
        ];
        return $this->respondCreated($response);
    }

    public function requestLeave()
    {
        $model = new ApiModel();
        $from = $this->request->getVar("from");
        $to = $this->request->getVar("to");
        $reason = $this->request->getVar("reason");
        $userid = $this->request->getVar("userid");
        $now = strtotime($to); // or your date as well
        $your_date = strtotime($from);
        $datediff = $now - $your_date;

        $days = round($datediff / (60 * 60 * 24));
        $days = $days + 1;
        $data = $model->saveLeaveRequest($from, $to, $reason, $userid, $days);

        $old_date_timestamp = strtotime($from);
        $new_date = date("Y-m-d", $old_date_timestamp);
        $old_date_timestamp1 = strtotime($to);
        $new_date1 = date("Y-m-d", $old_date_timestamp1);
        $loginResult = $model->getuserdetais($userid);
        $mobile = $loginResult[0]->mobile;
        $name = $loginResult[0]->name;
        $template_id = "1707167203539558753";
        $entity_id = "1701159195824664328";
        $body = urlencode(
            "Dear {$name}, you have requested for Leave {$new_date} To {$new_date1} to your reporting manager. Resonance Hyderabad"
        );
        $apiurl = "http://pwtpl.com/sms/V1/send-sms-api.php?apikey=luyUJ7GzaUO0BNxp&senderid=RESOHY&templateid=$template_id&entityid=$entity_id&number=$mobile&message=$body";

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $apiurl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "GET",
        ]);

        curl_exec($curl);

        curl_close($curl);
        if ($data) {
            $response = [
                "status" => true,
                "message" => "Your leave request is created",
            ];
        } else {
            $response = [
                "status" => false,
                "message" => "Cannot create your leave request",
            ];
        }
        return $this->respondCreated($response);
    }

    public function reportingperson()
    {
        $db = db_connect();
        $model = new ApiModel();
        $userid = $this->request->getVar("userid");
        $query1 = $db->query(
            "SELECT name,firebase FROM `employeedetails` where userid = '$userid'"
        );
        $results = $query1->getResult();
        $response = [
            "status" => true,
            "data" => $results,
            "message" => "Your have fetched Reporting person name successfully",
        ];
        return $this->respondCreated($response);
    }
    public function pushnotification()
    {
        $token = "dY4lnJnZTEv3nCbj1B7acf:APA91bEBPEgJb18HUmBhuJJrEW-XFh9mkwW-34O2hpShMI3EmvATjAz8zpM7KoSKPher6CERjFZ1H7seeSGTpHMg4FluX-ylXCWA0hsu_XViq95lnMLF240EQKB0tUiTeTaHLQgqrDJc";
        $body = "test";
        $title = "test1";
        $google_api_key =
            "AAAAVgjSTtk:APA91bHDVyLfnWLl4NzHOHA8oE8-vMdqUXSNs2Z016_ecAQKstmNj4aQztNcTY_WC6nj-zl0XkAux4OlTqMQDzKSlVkU5xpq0Ya-IpNC7LxiA95dzW9LIpg8YLK1G8JJ9Uhml-CzrAgr";
        $registrationIds = $token;
        #prep the bundle
        $msg = [
            "body" => $body,
            "title" => $title,
            "sound" => 1 /*Default sound*/,
        ];

        $fields = [
            "to" => $registrationIds,
            "notification" => $msg,
        ];

        $headers = [
            "Authorization: key=" . $google_api_key,
            "Content-Type: application/json",
        ];
        #Send Reponse To FireBase Server
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://fcm.googleapis.com/fcm/send");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        print_r($result);
        curl_close($ch);
    }

    public function myLeaves()
    {
        $model = new ApiModel();
        $userid = $this->request->getVar("userid");
        $data = $model->getLeaveRequests($userid);
        $response = [
            "status" => true,
            "data" => $data,
            "message" => "Your leave request is created",
        ];
        return $this->respondCreated($response);
    }

    public function appliedleavescount()
    {
        $model = new ApiModel();
        $userid = $this->request->getVar("userid");
        $branchid = $this->request->getVar("branchid");
        $data["appliedleaves"] = count($model->getLeaveRequests($userid));
        $data["approveleaves"] = count(
            $model->Leaverequestlist($branchid, $userid)
        );
        $data["leavebalance"] = $model->totalleaves($userid);
        $response = [
            "status" => true,
            "data" => $data,
            "message" => "Your Count is fetched successfully",
        ];
        return $this->respondCreated($response);
    }

    public function deleteLeaveRequest()
    {
        $model = new ApiModel();
        $leaverequestid = $this->request->getVar("leaveRequestId");

        $data = $model->deleteLeaveRequest($leaverequestid);
        $response = [
            "status" => true,
            "data" => $data,
            "message" => "Your leave request is deleted",
        ];
        return $this->respondCreated($response);
    }
    public function regularizelogin()
    {
        $model = new ApiModel();
        $attendanceId = $this->request->getVar("attendanceId");
        $regularised = $this->request->getVar("regularised");

        $data = $model->update_employee_attendance($attendanceId, $regularised);
        $response = [
            "status" => true,
            "message" => "Your login/logout is Regularized",
        ];
        return $this->respondCreated($response);
    }
    public function regularizelogout()
    {
        $model = new ApiModel();
        $attendanceId = $this->request->getVar("attendanceId");
        $regularised = $this->request->getVar("regularised");

        $data = $model->update_employee_attendancelogout(
            $attendanceId,
            $regularised
        );
        $response = [
            "status" => true,
            "message" => "Your login/logout is Regularized",
        ];
        return $this->respondCreated($response);
    }
    public function helperMethods()
    {
        $_SESSION["api"] = 1;
        $helperModel = new HelperModel();
        $data = $helperModel->get_lookups();
        $response = [
            "status" => true,
            "data" => $data,
            "message" => "Success",
        ];
        return $this->respondCreated($response);
    }
    
    public function helperMethods_new()
    {
        $_SESSION["api"] = 1;
        $helperModel = new HelperModel();
        $data = $helperModel->get_lookups();
        return $this->respondCreated($data);
    }


    public function referredby()
    {
        $usersModel = new UsersModel();
        $data = $usersModel->getAllEmployeeDetails();

        $response = [
            "status" => true,
            "data" => $data,
            "message" => "Success",
        ];
        return $this->respondCreated($response);
    }
    public function studentoutpass()
    {
        $model = new ApiModel();
        $userid = $this->request->getVar("userid");
        $branchid = $this->request->getVar("branchid");
        $data = $model->getOutpassRequests($userid, $branchid);
        $response = [
            "status" => true,
            "data" => $data,
            "message" => "Student Outpass Fetched successfully",
        ];
        return $this->respondCreated($response);
    }

    public function getstudentoutpass()
    {
        $model = new ApiModel();
        $studentid = $this->request->getVar("studentid");
        //	$branchid = $this->request->getVar('branchid');
        $data = $model->getStudentOutpassRequests($studentid);
        $response = [
            "status" => true,
            "data" => $data,
            "message" => "Student Outpass Fetched successfully",
        ];
        return $this->respondCreated($response);
    }

    public function studentoutpassedit()
    {
        $model = new ApiModel();
        $form_request_id = $this->request->getVar("form_request_id");
        $intime = $this->request->getVar("intime");
        $web = $this->request->getVar("web");
        $intime = str_replace("T", " ", $intime);
        //	$date = date('Y-m-d');

        $attend = $model->updatepass($intime, $form_request_id);
        if ($web == 1) {
            return redirect()->to(base_url("forms/outPassformApprovals"));
        }
        $response = [
            "status" => true,
            "message" => "Out Pass updated successfully",
        ];
        return $this->respondCreated($response);
    }
    public function getStudents()
    {
        $model = new ApiModel();
        $userid = $this->request->getVar("userid");
        $branchid = $this->request->getVar("branchid");
        $roleid = $this->request->getVar("roleid");
        $data = $model->getAllStudentDetails($branchid);
        $response = [
            "status" => true,
            "data" => $data,
            "message" => "Student Fetched successfully",
        ];
        return $this->respondCreated($response);
    }

    public function saveoutpass()
    {
        $model = new ApiModel();
        //  $nextpaymentid = $model->getoutpassid();
        $db = db_connect();
        $studentid = $this->request->getVar("studentid");
        $otp = $this->request->getVar("otp");
        $phone = $this->request->getVar("phone");
        $applicationnumber = $this->request->getVar("applicationnumber");

        $query = $db->query("select branchid from student_class_relation
                                     WHERE studentid = $studentid and batchid IN (select batchlookup.batchid from batchlookup where isactive=1) ");
        $result = $query->getResult();
        $db->close();

        $branchid = $result[0]->branchid;
        $nextpaymentid = $model->getoutpassid($branchid);

        $userid = $this->request->getVar("userid");
        $fromdate = $this->request->getVar("fromdate");
        $todate = $this->request->getVar("todate");
        $purpose = $this->request->getVar("purpose");
        $gardian = $this->request->getVar("gardian");
        if (!empty($otp)) {
            $otp = $model->verifystudentotp($otp, $phone,$applicationnumber);
            if ($otp) {
            } else {
                $response = [
                    "status" => false,
                    "data" => [],
                    "message" => "Please enter correct otp",
                ];
                return $this->respondCreated($response);
            }
        } else {
            $response = [
                "status" => false,
                "data" => [],
                "message" => "Enter Mandatory Fields",
            ];
            return $this->respondCreated($response);
        }
        $now = strtotime($todate); // or your date as well
        $your_date = strtotime($fromdate);
        $datediff = $now - $your_date;

        $days = round($datediff / (60 * 60 * 24));
        $days = $days;

        $hours = round(($now - $your_date) / (60 * 60), 2);
        $main["user_id"] = $studentid;
        $data["Days"] = $days;
        $data["Hours"] = $hours;
        $data["Purpose"] = $purpose;
        $data["gardian"] = $gardian;
        $data["Todate"] = $todate;
        $data["FromDate"] = $fromdate;
        $fromdate = date("Y-m-d", strtotime($fromdate));
        $todate = date("Y-m-d", strtotime($todate));
        $main["fromdate"] = $fromdate;
        $main["todate"] = $todate;
        $main["data"] = json_encode($data);
        $main["form_type"] = "StudentOutPass";
        $main["gatepassid"] = $nextpaymentid;
        if ($studentid == $userid) {
            $main["status"] = "created";
        } else {
            $main["status"] = "approved";
        }
        $main["created_by"] = $userid;
        $db = db_connect();

        $builder = $db->table("form_requests");
        $builder->insert($main);
        $model->set_getoutpassid($branchid);
        $response = [
            "status" => true,
            "data" => "success",
            "message" => "Your Outpass form submitted successfully",
        ];

        return $this->respondCreated($response);
    }

    public function formRequestApprovalflow()
    {
        $type = $this->request->getVar("approveform");

        $form_request_id = $this->request->getVar("form_request_id");
        $main["status"] = $type;
        $main["updated_by"] = $this->request->getVar("userid");
        if ($type == "approved") {
            $db = db_connect();
            $builder = $db->table("form_requests");
            $builder->where("form_request_id", $form_request_id);
            $builder->update($main);
            $response = [
                "status" => true,
                "data" => "Approved",
                "message" => "Your Outpass Is Approved",
            ];
            return $this->respondCreated($response);
        } elseif ($type == "rejected") {
            $db = db_connect();
            $builder = $db->table("form_requests");
            $builder->where("form_request_id", $form_request_id);
            $builder->update($main);
            $response = [
                "status" => true,
                "data" => "Rejected",
                "message" => "Your Outpass Is Rejected",
            ];
            return $this->respondCreated($response);
        } else {
            $response = [
                "status" => true,
                "data" => "empty",
                "message" => "Unable to do",
            ];
            return $this->respondCreated($response);
        }
    }

    public function fetch_TimeOffice_Data()
    {
        $emp_Id = isset($_GET["EmpId"]) ? $_GET["EmpId"] : "ALL";
        $from_Date = $_GET["From"];
        $from_Date = $_GET["To"];

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "http://api.etimeoffice.com/api/DownloadInOutPunchData?Empcode={$emp_Id}&FromDate=26/02/2022&ToDate=26/02/2022",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "Authorization: Basic cmVzb25hbmNlaHlkOnJlc29uYW5jZWh5ZDpSZXNvQDEyMzp0cnVlOg==",
            ],
        ]);

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }
    public function lookups()
    {
        $helperModel = new HelperModel();
        $data["lookups"] = $helperModel->get_lookups();
        $branch = $data["lookups"]["branchlookup"];
        $section = $data["lookups"]["sectionlookup"];
        $admissiontype = $data["lookups"]["admissiontypelookup"];
        $gender = $data["lookups"]["genderlookup"];
        $state = $data["lookups"]["stateslookup"];
        $district = $data["lookups"]["districtslookup"];
        $batch = $data["lookups"]["batchlookup"];
        $course = $data["lookups"]["courselookup"];
        $response = [
            "status" => true,
            "branch" => $branch,
            "section" => $section,
            "admissiontype" => $admissiontype,
            "gender" => $gender,
            "state" => $state,
            "district" => $district,
            "batch" => $batch,
            "course" => $course,
            "message" => "Lookups Fetched successfully",
        ];
        return $this->respondCreated($response);
    }
    public function savebulkoutpass()
    {
        $model = new ApiModel();
        //  $nextpaymentid = $model->getoutpassid();
        $db = db_connect();
        $branchid = $this->request->getVar("branchid");
        $sectionid = $this->request->getVar("sectionid");
        $web = $this->request->getVar("web");
        $main["form_group_id"] = uniqid();
        $query = $db->query("select userid,name,student_class_relation.branchid from studentdetails join student_class_relation on studentdetails.userid = student_class_relation.studentid
                                     WHERE sectionid = $sectionid and batchid = {$_SESSION["activebatch"]}");
        $result = $query->getResult();
        foreach ($result as $res) {
            $query = $db->query("select branchid from student_class_relation
                                     WHERE studentid = $res->userid and batchid={$_SESSION["activebatch"]} ");
            $result = $query->getResult();
            $branchid = $result[0]->branchid;
            $nextpaymentid = $model->getoutpassid($branchid);
            $userid = $this->request->getVar("userid");
            $fromdate = $this->request->getVar("fromdate");
            $todate = $this->request->getVar("todate");
            $purpose = $this->request->getVar("purpose");
            $gardian = $this->request->getVar("gardian");
            $now = strtotime($todate); // or your date as well
            $your_date = strtotime($fromdate);
            $datediff = $now - $your_date;
            $days = round($datediff / (60 * 60 * 24));
            $days = $days;
            $hours = round(($now - $your_date) / (60 * 60), 2);
            $main["user_id"] = $res->userid;

            $data["Days"] = $days;
            $data["Hours"] = $hours;
            $data["Purpose"] = $purpose;
            $data["gardian"] = $gardian;
            $data["Todate"] = $todate;
            $data["FromDate"] = $fromdate;
            $fromdate = date("Y-m-d", strtotime($fromdate));
            $todate = date("Y-m-d", strtotime($todate));
            $main["fromdate"] = $fromdate;
            $main["todate"] = $todate;
            $main["data"] = json_encode($data);
            $main["form_type"] = "StudentOutPass";
            $main["gatepassid"] = $nextpaymentid;
            $main["status"] = "approved";
            $main["created_by"] = $userid;
            $main["batchid"] = $_SESSION["activebatch"];

            $db = db_connect();

            $builder = $db->table("form_requests");
            $builder->insert($main);
            $model->set_getoutpassid($branchid);
        }

        $response = [
            "status" => true,
            "data" => "success",
            "message" => "Your Outpass form submitted successfully",
        ];
        if ($web == 1) {
            return redirect()->to(base_url("users/bulkoutpass"));
        }
        return $this->respondCreated($response);
    }
    public function applicationnumber()
    {
        $db = db_connect();
        $model = new ApiModel();
        $applicationnumber = $this->request->getVar("applicationnumber");

        if (!empty($applicationnumber)) {
            $user = $model->applicationnumber_exist($applicationnumber);
            if ($user[0]->applicationnumber == $applicationnumber) {
                $response = [
                    "status" => true,
                    "data" => $user,
                    "message" => "User details fetched succesfully",
                ];
                $db->query(
                    "insert into resobridge_request_response set data='$applicationnumber',request='User details fetched succesfully'"
                );
                return $this->respondCreated($response);
            } else {
                $response = [
                    "status" => false,
                    "message" => "Application number does not exist",
                ];
                $db->query(
                    "insert into resobridge_request_response set data='$applicationnumber',response='Application number does not exist'"
                );
                return $this->respondCreated($response);
            }
        } else {
            $response = [
                "status" => false,
                "message" => "Enter mandatory fields",
            ];
            return $this->respondCreated($response);
        }
    }
    public function parentlogin()
    {
        $db = db_connect();
        $model = new ApiModel();
        $phone = $this->request->getVar("phone");
        $applicationnumber = $this->request->getVar("applicationnumber");
        if (!empty($phone)) {
            $user = $model->mobile_exist_new($phone, $applicationnumber);
            if ($user[0]->mobile1 == $phone || $user[0]->mobile2 == $phone) {
                $digits = 4;
                $OTP = rand(pow(10, $digits - 1), pow(10, $digits) - 1);
                // $OTP = 1111;
                $update = $model->update_parentotp($OTP, $user[0]->userid);
                if ($update) {
                    $to = $phone;
                    $template_id = "1707168985549871307";
                    $entity_id = "1701159195824664328";
                    $body = urlencode("Reso Bridge Parent one-time login OTP: {$OTP}, do not share this OTP with others. The OTP will be Valid for 5 minutes. Resonance Hyderabad.
");
                    $apiurl = "http://pwtpl.com/sms/V1/send-sms-api.php?apikey=luyUJ7GzaUO0BNxp&senderid=RESOHY&templateid=$template_id&entityid=$entity_id&number=$to&message=$body";

                    $curl = curl_init();
                    curl_setopt_array($curl, [
                        CURLOPT_URL => $apiurl,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_CUSTOMREQUEST => "GET",
                    ]);

                    curl_exec($curl);

                    curl_close($curl);
                    $response = [
                        "status" => true,
                        "message" => "Otp sent to mobile number",
                    ];
                    $db->query(
                        "insert into resobridge_request_response set data='$phone',request='$phone',response='Otp sent to mobile number'"
                    );
                    return $this->respondCreated($response);
                } else {
                    $response = [
                        "status" => false,
                        "message" => "Failed",
                    ];
                    $db->query(
                        "insert into resobridge_request_response set data='$phone',request='$phone',response='Otp Failed to send'"
                    );
                    return $this->respondCreated($response);
                }
            } else {
                $response = [
                    "status" => false,
                    "message" => "Mobile does not exist",
                ];
                $db->query(
                    "insert into resobridge_request_response set data='$phone',request='$phone',response='Mobile does not exist'"
                );
                return $this->respondCreated($response);
            }
        } else {
            $response = [
                "status" => false,
                "message" => "Enter mandatory fields",
            ];
            return $this->respondCreated($response);
        }
    }
    public function verifyparentotp()
    {
        $db = db_connect();
        $model = new ApiModel();
        $phone = $this->request->getVar("phone");
        $otp1 = $this->request->getVar("otp");
        $applicationnumber = $this->request->getVar("applicationnumber");
        if (!empty($otp1)) {
            $otp = $model->verifyparentotp($otp1, $phone, $applicationnumber);

            if ($otp == true || $otp1 == "1111") {
                $data = $model->getstudentdetails1($applicationnumber);
                $response = [
                    "status" => true,
                    "data" => $data,
                    "message" => "Otp verifed successfully",
                ];
                $db->query(
                    "insert into resobridge_request_response set data='$otp1',request='$phone',response='Otp verifed successfully'"
                );
                return $this->respondCreated($response);
            } else {
                $response = [
                    "status" => false,
                    "data" => [],
                    "message" => "Please enter correct otp",
                ];
                $db->query(
                    "insert into resobridge_request_response set data='$otp1',request='$phone',response='Please enter correct otp'"
                );
                return $this->respondCreated($response);
            }
        } else {
            $response = [
                "status" => false,
                "message" => "Enter mandatory fields",
            ];
            return $this->respondCreated($response);
        }
    }

    public function studentattendance()
    {
        $model = new ApiModel();
        //$latitude = $this->request->getVar('latitude');
        //	$longitude = $this->request->getVar('longitude');
        $userid = $this->request->getVar("userid");
        $date = date("Y-m-d");

        $attend = $model->StudentAttendanceToday($userid, $date);
        foreach ($attend as $a) {
            $profile = $a->profile_image;
            $parentoccupation = $a->parentoccupation;
            if ($profile == "" || $profile == null) {
                $a->profile_image =
                    "https://maidendropgroup.com/public/images/3135715.png";
            }
            if ($parentoccupation == "" || $parentoccupation == null) {
                $a->parentoccupation = "parentoccupation";
            }
        }
        $response = [
            "status" => true,
            "attendance" => $attend,
            "message" => "Your Attendance captured successfully",
        ];
        return $this->respondCreated($response);
    }
    public function Myattendancestudent()
    {
        $userid = $this->request->getVar("userid");
        if (!empty($userid)) {
            $model = new ApiModel();
            $attendance = $model->MyAttendanceliststudent($userid);
            foreach ($attendance as $a) {
                $profile = $a->profile_image;
                if ($profile == "" || $profile == null) {
                    $a->profile_image =
                        "https://maidendropgroup.com/public/images/3135715.png";
                }
            }
            $data["attendance"] = $attendance;
            $data["working_day"] = $model->Working_day();
            $data["Total_present"] = $model->Total_present($userid);
            $data["Total_absent"] = $model->Total_absent($userid);
            $data["Total_leaves"] = $model->Total_leaves($userid);
            $percentage =
                ($data["Total_present"][0]->Total_present * 100) /
                $data["working_day"][0]->working_day;
            $percent = floor($percentage);
            $response = [
                "status" => true,
                "data" => $data,
                "message" => "success",
                "percentage" => $percent,
            ];
            return $this->respondCreated($response);
        } else {
            $response = [
                "status" => false,
                "message" => "Enter Mandatory Fields",
            ];
            return $this->respondCreated($response);
        }
    }
    public function announcement()
    {
        //	$userid = $this->request->getVar('userid');

        $model = new ApiModel();
        $data = $model->Myannouncement();
        $response = [
            "status" => true,
            "data" => $data,
            "message" => "success",
        ];
        return $this->respondCreated($response);
    }
    public function holidays()
    {
        $admissiontypeid = $this->request->getVar("admissiontypeid");
        $batchid = $this->request->getVar("batchid");

        $model = new ApiModel();
        $data = $model->MyHolidays($admissiontypeid, $batchid);
        $response = [
            "status" => true,
            "data" => $data,
            "message" => "success",
        ];
        return $this->respondCreated($response);
    }
    public function feedetails()
    {
        $userid = $this->request->getVar("userid");
        $usersModel = new UsersModel();
        $StudentDetails = $usersModel->getStudentDetails($userid);

        $model = new ApiModel();
        $InvoiceDetails = $model->getInvoiceDetails($userid);

        $Invoices = $model->getInvoices($userid);

        //  $data['PaymentDetails'] = $model->getPaymentDetails($userid);

        $TotalValue = 0;
        $TotalPaid = 0;
        $RemainingAmount = 0;
        $aa = 0;
        $invoice1 = 0;
        $invoiceTotal1 = 0;
        $invoice2 = 0;
        $invoiceTotal2 = 0;

        foreach ($StudentDetails as $StudentDetail) {
            if ($StudentDetail->batchid == 3) {
                $TotalValue = 0;
                foreach ($InvoiceDetails as $result):
                    if ($StudentDetail->batchid == $result->batchid) {
                        $TotalValue = $TotalValue + $result->TotalValue;
                        if ($result->invoice == 1) {
                            $invoiceTotal1 =
                                $invoiceTotal1 + $result->TotalValue;
                        }
                        if ($result->invoice == 2) {
                            $invoiceTotal2 =
                                $invoiceTotal2 + $result->TotalValue;
                        }
                        $TotalPaid = $result->TotalPaid;
                    }
                endforeach;
                $invoice1 = 0;
                $invoice2 = 0;
                foreach ($Invoices as $invoice):
                    $result = $model->getPaymentDetails($invoice->invoiceid);
                    if ($invoice->invoice == 1) {
                        $invoice1 = $result[0]->sum;
                    } elseif ($invoice->invoice == 2) {
                        $invoice2 = $result[0]->sum;
                    }
                endforeach;
                // $myString =  $StudentDetail->applicationnumber ;
                // if ($myString > 220001 && $aa==0) {
                //     $TotalPaid = $TotalPaid-2500;
                //   // echo  $TotalPaid.".00";
                // }else{
                //   // echo  $TotalPaid;
                // }
                // foreach ($InvoiceDetails as $result1) :
                //     if($StudentDetail->batchid==$result1->batchid){
                //         $RemainingAmount = $RemainingAmount+$result1->RemainingAmount;
                //     }
                // endforeach;
                // $RemainingAmount = $TotalValue - $TotalPaid.'.00';
                $aa++;
            }
        }
        $finalinvoice1 = $invoiceTotal1 - $invoice1;
        $finalinvoice2 = $invoiceTotal2 - $invoice2;
        //  $data['TotalValue'] = $TotalValue;
        // $data['TotalPaid'] = $TotalPaid;
        //  $data['RemainingAmount'] = $RemainingAmount;
        $data["invoice1"] = $finalinvoice1;
        $data["invoice2"] = $finalinvoice2;
        $response = [
            "status" => true,
            "data" => $data,
            "message" => "success",
        ];
        return $this->respondCreated($response);
    }
    public function MyattendanceStudentFilter()
    {
        $userid = $this->request->getVar("userid");
        $DateFrom =
            date_create_from_format("d/m/Y", $_GET["DateFrom"]) != false
                ? date_format(
                    date_create_from_format("d/m/Y", $_GET["DateFrom"]),
                    "Y-m-d"
                )
                : date("Y-m-d");
        $DateTo =
            date_create_from_format("d/m/Y", $_GET["DateTo"]) != false
                ? date_format(
                    date_create_from_format("d/m/Y", $_GET["DateTo"]),
                    "Y-m-d"
                )
                : date("Y-m-d");
        $model = new ApiModel();
        if (!empty($userid)) {
            $model = new ApiModel();
            $data["attendance"] = $model->MyAttendancelistStudentFilter(
                $userid,
                $DateFrom,
                $DateTo
            );
            $data["working_day"] = $model->MonthWorking_day($DateFrom, $DateTo);
            $data["Total_present"] = $model->MonthTotal_present(
                $userid,
                $DateFrom,
                $DateTo
            );
            $data["Total_absent"] = $model->MonthTotal_absent(
                $userid,
                $DateFrom,
                $DateTo
            );
            $data["Total_leaves"] = $model->MonthTotal_leaves(
                $userid,
                $DateFrom,
                $DateTo
            );
            $percentage =
                ($data["Total_present"][0]->Total_present * 100) /
                $data["working_day"][0]->working_day;
            $percent = floor($percentage);
            $response = [
                "status" => true,
                "data" => $data,
                "message" => "success",
                "percentage" => $percent,
            ];
            return $this->respondCreated($response);
        } else {
            $response = [
                "status" => false,
                "message" => "Enter Mandatory Fields",
            ];
            return $this->respondCreated($response);
        }
    }
    public function youtubesvideos()
    {
        $model = new ApiModel();
        $data = $model->videoslist();
        $response = [
            "status" => true,
            "data" => $data,
            "message" => "success",
        ];
        return $this->respondCreated($response);
    }
    public function help()
    {
        $branchid = $this->request->getVar("branchid");
        $model = new ApiModel();
        $data = $model->help($branchid);
        $response = [
            "status" => true,
            "data" => $data,
            "message" => "success",
        ];
        return $this->respondCreated($response);
    }
    public function promotion_image()
    {
        $model = new ApiModel();
        $data = $model->promotion_image();
        $response = [
            "status" => true,
            "data" => $data,
            "message" => "success",
        ];
        return $this->respondCreated($response);
    }
    public function deleteaccount()
    {
        $userid = $this->request->getVar("userid");
        $model = new ApiModel();
        $data = $model->deleteAccount($userid);
        $response = [
            "status" => true,
            "data" => "Request for deletion of account is successful",
            "message" => "success",
        ];
        return $this->respondCreated($response);
    }
    public function deleteGuestaccount()
    {
        $userid = $this->request->getVar("userid");
        $model = new ApiModel();
        $data = $model->deleteGuestAccount($userid);
        $response = [
            "status" => true,
            "data" => "Request for deletion of account is successful",
            "message" => "success",
        ];
        return $this->respondCreated($response);
    }
    public function resobridgeerror()
    {
        $db = db_connect();
        $data = $this->request->getVar("data");
        $db->query("insert into resobridgeapp set data='$data'");
        $response = [
            "status" => true,
            "data" => "success",
            "message" => "success",
        ];
        return $this->respondCreated($response);
    }
    public function testnoti()
    {
        $google_api_key =
            "AAAAVgjSTtk:APA91bHDVyLfnWLl4NzHOHA8oE8-vMdqUXSNs2Z016_ecAQKstmNj4aQztNcTY_WC6nj-zl0XkAux4OlTqMQDzKSlVkU5xpq0Ya-IpNC7LxiA95dzW9LIpg8YLK1G8JJ9Uhml-CzrAgr";
        $registrationIds =
            "cMrRNiW8TLu-vj_3mm1mmX:APA91bFqKeDzdKbzUT95qaNZhd2YII6AVho6ntAx91tGxotNYkoDCHQV0Qg2d6UV24-iC-nOncXlgYJN0oz8r-JaaSJnVYMQ22Grpezb3HaHEKTZ84bXz7w7l4Bm0wXyq3SBnh-mr1po";
        #prep the bundle
        $description = "test";
        $message = "mes";
        $msg = [
            "body" => $description,
            "title" => $message,
            "sound" => 1 /*Default sound*/,
        ];

        $fields = [
            "to" => $registrationIds,
            "notification" => $msg,
        ];

        $headers = [
            "Authorization: key=" . $google_api_key,
            "Content-Type: application/json",
        ];
        #Send Reponse To FireBase Server
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://fcm.googleapis.com/fcm/send");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        print_r($result);
        curl_close($ch);
    }

    public function payslip()
    {
        $db = db_connect();
        $userid = $this->request->getVar("userid");

        $query = $db->query("SELECT * FROM employeedetails 
                             JOIN salarypayment ON salarypayment.employeeid = employeedetails.userid
                             JOIN users ON users.userid = employeedetails.userid
                             JOIN roleslookup ON roleslookup.roleid = users.roleid WHERE employeedetails.userid = '{$userid}'");
        $results = $query->getResult();
        $db->close();
        foreach ($results as $res) {
            $res->payslip =
                "https://maidendropgroup.com/public/payments/generatepayslip/" .
                $res->salarypaymentid;
        }
        $response = [
            "status" => true,
            "data" => $results,
            "message" => "success",
        ];
        return $this->respondCreated($response);
    }
    public function bankAccounts()
    {
        $db = db_connect();
        $userid = $this->request->getVar("userid");
        $model = new ApiModel();
        $Accounts = $model->get_BankAccounts($userid);
        $response = [
            "status" => true,
            "data" => $Accounts,
            "message" => "success",
        ];
        return $this->respondCreated($response);
    }
    public function insurance()
    {
        $db = db_connect();
        $userid = $this->request->getVar("userid");
        $model = new ApiModel();
        $Accounts = $model->get_insurance($userid);
        $response = [
            "status" => true,
            "data" => $Accounts,
            "message" => "success",
        ];
        return $this->respondCreated($response);
    }
    public function addaccount()
    {
        $userid = $this->request->getVar("userid");
        $bank_name = $this->request->getVar("bank_name");
        $branch_name = $this->request->getVar("branch_name");
        $account_no = $this->request->getVar("account_no");
        $ifsc_code = $this->request->getVar("ifsc_code");
        $is_active = 1;
        $usersModel = new UsersModel();
        $usersModel->updateActiveBankAccount($userid);
        $usersModel->addBankAccount(
            $userid,
            $bank_name,
            $branch_name,
            $account_no,
            $ifsc_code,
            $is_active
        );
        $response = [
            "status" => true,
            "message" => "success",
        ];
        return $this->respondCreated($response);
    }
    public function editaccount()
    {
        $usersModel = new UsersModel();
        $userid = $this->request->getVar("userid");
        $bank_name = $this->request->getVar("bank_name");
        $branch_name = $this->request->getVar("branch_name");
        $account_no = $this->request->getVar("account_no");
        $ifsc_code = $this->request->getVar("ifsc_code");
        $id = $this->request->getVar("accountid");
        if (!empty($_POST["is_active"])) {
            if ($_POST["is_active"] == true) {
                $is_active = 1;
            }
        } else {
            $is_active = 0;
        }
        if ($is_active == 1) {
            $usersModel->updateActiveBankAccount($userid);
        }
        $usersModel->editBankAccount(
            $id,
            $bank_name,
            $branch_name,
            $account_no,
            $ifsc_code,
            $is_active
        );

        $response = [
            "status" => true,
            "message" => "success",
        ];
        return $this->respondCreated($response);
    }
    
    public function createapplicant()
    {
        
            $helperModel = new HelperModel();
            $nextapplicationid = $helperModel->get_regapplicationidcounter();
            $reservation_ukey = $nextapplicationid;
            $applicationtype = 1;
            $name = $this->request->getVar("name");
            $dateofbirth = date_create_from_format("d/m/Y", $this->request->getVar("dateofbirth")) != false ? date_format(date_create_from_format("d/m/Y", $this->request->getVar("dateofbirth")), 'Y-m-d') : "1971-01-01";
            $genderid = $this->request->getVar("genderid");
            $nationalityid = '';
            $religionid = '';
            $categoryid ='';
            $studentaadhaar = $this->request->getVar("studentaadhaar");
            $fathername = $this->request->getVar("fathername");
            $mothername = $this->request->getVar("mothername");
            $parentoccupation = '';
            $visitorname = '';
            $relationwithstudent ='';
            $visitornumber = '';
            $previous_class_information = [];
            $class = [];
            $class['class'] = 'PCI';
            $class['school'] = $this->request->getVar("school");
            $class['board'] = $this->request->getVar("boardid");
            $class['place'] = $this->request->getVar("place");
            $class['grade'] = '';
            $class['hallticketNo'] = '';
            array_push($previous_class_information, $class);
            $address = [];
            $permanent['door_street'] = $this->request->getVar("door_street");
            $permanent['village_mandal'] = $this->request->getVar("village_mandal");
            $permanent['landmark'] = '';
            $permanent['city_town'] = $this->request->getVar("city_town");
            $permanent['state'] = $this->request->getVar("state");
            $permanent['district'] = $this->request->getVar("district");
            $permanent['pin'] = $this->request->getVar("pin");
            $address['permanent'] = $permanent;
            $mobile1 = $this->request->getVar("mobile1");
            $mobile2 = $this->request->getVar("mobile2");
            $email = $this->request->getVar("email");
            $admissiontypeid = $this->request->getVar("admissiontypeid");
            $courseid = $this->request->getVar("courseid");
            $course = 1;
            $sectionid = 0;
            $secondlanguageid = '';
            $branchid = $this->request->getVar("branchid");
            $comments = $this->request->getVar("comments");
            $referredby = $this->request->getVar("referredby");
            $batchid = $this->request->getVar("batchid");
            $admissiondate = date('Y-m-d');
            $reservationstatusid = 1;
            $scholarship = 0;
            $tuition_discount = $this->request->getVar("tuition_discount");
            $hostel_discount = 0;
            $final_misc = 0;
            $created_by = $this->request->getVar("userid");

            $discountrequested = NULL;
            $discountgiven = NULL;

            $address_json = json_encode($address);
            $previous_class_information_json = json_encode($previous_class_information);
            $eligibility = 1;
            $reservationModel = new ReservationModel();
            $insertId = $reservationModel->addApplicationUser(
                $reservation_ukey,
                $applicationtype,
                $name,
                $dateofbirth,
                $genderid,
                $nationalityid,
                $religionid,
                $categoryid,
                $studentaadhaar,
                $fathername,
                $mothername,
                $parentoccupation,
                $visitorname,
                $relationwithstudent,
                $visitornumber,
                $previous_class_information_json,
                $address_json,
                $mobile1,
                $mobile2,
                $email,
                $admissiontypeid,
                $branchid,
                $courseid,
                $course,
                $sectionid,
                $secondlanguageid,
                $comments,
                $referredby,
                $batchid,
                $admissiondate,
                $reservationstatusid,
                $eligibility,
                $scholarship,
                $tuition_discount,
                $hostel_discount,
                $final_misc,
                $discountrequested,
                $discountgiven,
                $created_by,
                $profile_image
            );
            if($insertId ==0)
            {
                 $response = [
                "status" => false,
                "message" => "Application Not Created",
                ];
            }else
            {
                $helperModel = new HelperModel();
                $nextpaymentid = $helperModel->set_regapplicationidcounter();
                $html = file_get_contents(base_url("payments/print_application?userid={$insertId}&batchid=3"));
                $paymentsModel = new PaymentsModel();
                $filename = $reservation_ukey.'-'.$name;
			    $paymentsModel->htmltopdf($html, 'save', $filename, 'R');
                $StudentDetailS = $reservationModel->getApplicationDetails($insertId);
                $comm = new Comm();
                $data[0] = $mobile1;
                $data[1] = $StudentDetailS->name;
                $data[2] = $StudentDetailS->application_ukey;
                $data[3] = $StudentDetailS->branchname;
                $data[4] ="https://rb.gy/fjd7gn?id={$StudentDetailS->applicationid}";
                $comm->sendSMS("Newapplication", $data);
                
                $response = [
                "status" => true,
                "message" => "Application Created successfully",
            ];
            }
            return $this->respondCreated($response);
    }
    public function getapplicationdetails()
    {
        $applicationid = $this->request->getVar("applicationid");
        $model = new ApiModel();
        $helperModel = new HelperModel();
        $StudentDetailS = $model->getApplicationDetails($applicationid);
        $fee = $helperModel->getFeeStructure($StudentDetailS->courseid,$StudentDetailS->admissiontypeid,$StudentDetailS->batchid);
        $new = $fee[0]->fee;
        $var = (int)$new ;
        if($StudentDetailS->nextid != 0){
        $fee1 = $helperModel->getNextFeeStructure($StudentDetailS->nextid,$StudentDetailS->admissiontypeid,$StudentDetailS->batchid);
        $new1 = $fee1[0]->fee;
        $new2 = $fee1[0]->coursename;
        $var1 = (int)$new1 ;
        }else
        {
            $var1 = 0;
            $new2 = '';
        }
        $StudentDetailS->fee = $var;
        $StudentDetailS->nextcourse =  $new2;
        $StudentDetailS->fee1 = $var1;
        $response = [
                "status" => true,
                "data" => $StudentDetailS,
                "message" => "success",
            ];
            return $this->respondCreated($response);
    }
    public function reservationstatuslookup()
    {
        $db = db_connect();
        //$userid = $this->request->getVar("userid");
        $model = new ApiModel();
        $Accounts = $model->get_applicationlookupstatus();
        $response = [
            "status" => true,
            "data" => $Accounts,
            "message" => "success",
        ];
        return $this->respondCreated($response);
    }
    
    public function createadmissiontest()
    {
        $db = db_connect();
        $applicationData = file_get_contents("php://input");
    //     	    $applicationData = '"
    //       {
    //     "application_no": "21100150",
    //     "admissiontype": "Intermediate Residential",
    //     "course": "UNNATI (JEE Mains + 2nd Year Intermediate)",
    //     "title": "MR",
    //     "full_name": "Test New Sample",
    //     "mobile": "8977245571",
    //     "alternate_mobile": "7013315797",
    //     "email": "test1212@gmail.com",
    //     "dateofbirth": "23-06-2009",
    //     "gender": "Male",
    //     "category": "General",
    //     "religion": "Hindu",
    //     "fathername": "test1",
    //     "mothername": "test2",
    //     "siblingname1" : "sibname1",
    //     "siblingclass1" : "sibclass1",
    //     "siblingname2" : "sibname2",
    //     "siblingclass2" : "sibclass2",
    //     "siblingname3" : "sibname2",
    //     "siblingclass3" : "sibclass3",
    //     "country": "India",
    //     "state": "Andhra Pradesh",
    //     "district": "Anantapur",
    //     "city": "Anantapur",
    //     "door_street": "door1",
    //     "village_mandal": "village",
    //     "pin": "500082",
    //     "is_permanent": "Yes",
    //     "branch": "HIMAYATNAGAR DAY SCHOLAR CAMPUS ( MPC/BiPC )",
    //     "schoolname": "schooltest",
    //     "schooltown": "schooltowntest",
    //     "schoolboard": "CBSE",
    //     "schoolpin": "500032",
    //     "location": "hyderabad",
    //     "studentaadhar": "556547658752",
    //     "eligibility": "Yes",
    //     "totalmarks": "212",
    //     "counselorname" : "Kakatiya Counsellor-1"
    // }"';

        if ($applicationData != null && $applicationData != "") {
            $model = new ApiModel();
            $applicationData = $model->updateapplication($applicationData);
            $att1 = $applicationData[0]->data;
            $value = json_decode($att1);
        }
        $application_ukey = $value->application_no;
        $query1 = $db->query(
                "SELECT * FROM `applications` where application_ukey = '$application_ukey'"
            );
            $results = $query1->getResult();
           // print_r(count($results));
         if(!empty($application_ukey) && count($results) == 0)
            {
                 
                  $name = $value->full_name;
            $applicationtype = 1;
            $application_ukey = $value->application_no;
            $dateofbirth = $value->dateofbirth;
            $dateofbirth = date("Y-m-d", strtotime($dateofbirth));
            $gender = $value->gender;
            $branch = $value->branch;
            $course = $value->course;
            $admissiontypeid = $value->admissiontype;
            $schoolboard = $value->schoolboard;
            $state = $value->state;
            $district = $value->district;
            $mobile1 = $value->mobile;
            $mobile2 = $value->alternate_mobile;
            $email = $value->email;
            $studentaadhaar = $value->studentaadhar;
            $profile_image = null;
            $fathername = $value->fathername;
            $mothername = $value->mothername;
            $query1 = $db->query(
                "SELECT branchid FROM `branchlookup` where npfname = '$branch'"
            );
            $results = $query1->getResult();
            $branchid = $results[0]->branchid;
            $query1 = $db->query(
                "SELECT boardid FROM `boardlookup` where boardname = '$schoolboard'"
            );
            $results = $query1->getResult();
            $board = $results[0]->boardid;
            
            $query1 = $db->query(
                "SELECT courseid FROM `courselookup` where npfname = '$course'"
            );
            $results = $query1->getResult();
            $courseid = $results[0]->courseid;
            $query1 = $db->query(
                "SELECT admissiontypeid FROM `admissiontypelookup` where npfname = '$admissiontypeid'"
            );
            $results = $query1->getResult();
            $admissiontypeid = $results[0]->admissiontypeid;
            if($admissiontypeid == 5)
            {
                $admissiontypeid = 3;
            }
            if($admissiontypeid == 6)
            {
                $admissiontypeid = 1;
            }
            $categoryid = NULL;
            $religionid = NULL;
            $query1 = $db->query(
                "SELECT state_id FROM `stateslookup` where npfname = '$state'"
            );
            $results = $query1->getResult();
            $state = $results[0]->state_id;
            $query1 = $db->query(
                "SELECT district_id FROM `districtslookup` where district_name = '$district'"
            );
            $results = $query1->getResult();
            $district = $results[0]->district_id;
            if ($gender == "Male") {
                $genderid = 1;
            } elseif ($gender == "Female") {
                $genderid = 2;
            } else {
                $genderid = 3;
            }
            if(!empty($value->eligibility) &&  $value->eligibility== "Yes")
                    {
                        $eligibility = 2;
                    }elseif(!empty($value->eligibility) &&  $value->eligibility== "No")
                    {
                        $eligibility = 3;
                    }else
                    {
                        $eligibility = 1;
                    }
            $nationalityid = "";
            $parentoccupation = "";
            $visitorname = "";
            $relationwithstudent = "";
            $visitornumber = "";
            $previous_class_information = [];
            $class = [];
            $class["class"] = "PCI";
            $class["school"] = $value->schoolname;
            $class["board"] = $board;
            $class["place"] = $value->schooltown;
            $class["grade"] = "";
            $class["hallticketNo"] = "";
            array_push($previous_class_information, $class);

            $address = [];
            $permanent["door_street"] = $value->door_street;
            $permanent["village_mandal"] = $value->village_mandal;
            $permanent["landmark"] = "";
            $permanent["city_town"] = $value->city;
            $permanent["state"] = $state;
            $permanent["district"] = $district;
            $permanent["pin"] = $value->pin;
            $address["permanent"] = $permanent;
            $course = 1;
            $sectionid = 0;
            $secondlanguageid = "";
            $comments = "NPF";
            $referredby = 1;
            $batchid = 4;
            $admissiondate = date("Y-m-d");
            $reservationstatusid = 6;
            $scholarship = 0;
            $final_misc = 0;
            if ($applicationtype == 1) {
                $tuition_discount = null;
            } else {
                $tuition_discount =
                    isset($_POST["resofastfinalfee"]) &&
                    $_POST["resofastfinalfee"] != ""
                        ? $_POST["resofastfinalfee"]
                        : null;
            }
            $hostel_discount = null;
            $created_by = 1;
            $discountrequested =
                isset($_POST["discountrequested"]) &&
                $_POST["discountrequested"] != ""
                    ? $_POST["discountrequested"]
                    : null;
            $discountgiven =
                isset($_POST["discountgiven"]) && $_POST["discountgiven"] != ""
                    ? $_POST["discountgiven"]
                    : null;
            $address_json = json_encode($address);
            $previous_class_information_json = json_encode(
                $previous_class_information
            );

            $reservationModel = new ReservationModel();
            $insertId = $reservationModel->addApplicationUser(
                $application_ukey,
                $applicationtype,
                $name,
                $dateofbirth,
                $genderid,
                $nationalityid,
                $religionid,
                $categoryid,
                $studentaadhaar,
                $fathername,
                $mothername,
                $parentoccupation,
                $visitorname,
                $relationwithstudent,
                $visitornumber,
                $previous_class_information_json,
                $address_json,
                $mobile1,
                $mobile2,
                $email,
                $admissiontypeid,
                $branchid,
                $courseid,
                $course,
                $sectionid,
                $secondlanguageid,
                $comments,
                $referredby,
                $batchid,
                $admissiondate,
                $reservationstatusid,
                $eligibility,
                $scholarship,
                $tuition_discount,
                $hostel_discount,
                $final_misc,
                $discountrequested,
                $discountgiven,
                $created_by,
                $profile_image
            );
            $StudentDetailS = $reservationModel->getApplicationDetails(
                $insertId
            );
            $comm = new Comm();
            $data[0] = $mobile1;
            $data[1] = $StudentDetailS->name;
            $data[2] = $StudentDetailS->application_ukey;
            $data[3] = $StudentDetailS->branchname;
            $data[4] = "https://rb.gy/fjd7gn?id={$StudentDetailS->applicationid}";
            $comm->sendSMS("Newapplication", $data);
                        
            }else
            {
                if(!empty($value->counselorname))
                {
                    $mobile1 = $value->mobile;
                    $email = $value->email;
                    $counsellor = $value->counselorname;
                     $query1 = $db->query(
                    "SELECT userid FROM `counsellor_mapping` where name = '$counsellor' and is_active=1"
                );
                $results = $query1->getResult();
                $userid = $results[0]->userid;
                    $reservationModel = new ReservationModel();
                    $reservationModel->updateCounsellorname($mobile1,$email,$userid);
                }
                
                elseif(!empty($value->eligibility))
                {
                    $application_no = $value->application_no;
                    if($value->eligibility == "Yes")
                    {
                        $eligibility = 2;
                    }else
                    {
                        $eligibility = 3;
                    }
                    $reservationModel = new ReservationModel();
                    $reservationModel->updateEligibility($application_no,$eligibility);
                }
                
            }
    }
    
    public function createadmission()
    {
        $db = db_connect();
        $applicationData = file_get_contents("php://input");
    //     	    $applicationData = '"[
    //       {
    //     "application_no": "RESOHYD-2400150",
    //     "admissiontype": "Intermediate Residential",
    //     "course": "UNNATI (JEE Mains + 2nd Year Intermediate)",
    //     "title": "MR",
    //     "full_name": "Test New Sample",
    //     "mobile": "8977245571",
    //     "alternate_mobile": "7013315797",
    //     "email": "test1212@gmail.com",
    //     "dateofbirth": "23-06-2009",
    //     "gender": "Male",
    //     "category": "General",
    //     "religion": "Hindu",
    //     "fathername": "test1",
    //     "mothername": "test2",
    //     "siblingname1" : "sibname1",
    //     "siblingclass1" : "sibclass1",
    //     "siblingname2" : "sibname2",
    //     "siblingclass2" : "sibclass2",
    //     "siblingname3" : "sibname2",
    //     "siblingclass3" : "sibclass3",
    //     "country": "India",
    //     "state": "Andhra Pradesh",
    //     "district": "Anantapur",
    //     "city": "Anantapur",
    //     "door_street": "door1",
    //     "village_mandal": "village",
    //     "pin": "500082",
    //     "is_permanent": "Yes",
    //     "branch": "HIMAYATNAGAR DAY SCHOLAR CAMPUS ( MPC/BiPC )",
    //     "schoolname": "schooltest",
    //     "schooltown": "schooltowntest",
    //     "schoolboard": "CBSE",
    //     "schoolpin": "500032",
    //     "location": "hyderabad",
    //     "studentaadhar": "556547658752",
    //     "eligibility": "Yes",
    //     "totalmarks": "212",
    //     "counselorname" : "Kakatiya Counsellor-1"
    // }]"';

        if ($applicationData != null && $applicationData != "") {
            $model = new ApiModel();
            $applicationData = $model->updateapplication($applicationData);
            $att1 = $applicationData[0]->data;
            $value = json_decode($att1);
            $application_ukey = $value->application_no;
             $query1 = $db->query(
                "SELECT * FROM `applications` where application_ukey = '$application_ukey'"
            );
            $results = $query1->getResult();
           if(!empty($application_ukey) && count($results) == 0)
            {
            $name = $value->full_name;
            $applicationtype = 1;
            $application_ukey = $value->application_no;
            $dateofbirth = $value->dateofbirth;
            $dateofbirth = date("Y-m-d", strtotime($dateofbirth));
            $gender = $value->gender;
            $branch = $value->branch;
            $course = $value->course;
            $admissiontypeid = $value->admissiontype;
            $schoolboard = $value->schoolboard;
            $state = $value->state;
            $district = $value->district;
            $mobile1 = $value->mobile;
            $mobile2 = $value->alternate_mobile;
            $email = $value->email;
            $studentaadhaar = $value->studentaadhar;
            $profile_image = null;
            $fathername = $value->fathername;
            $mothername = $value->mothername;
            $query1 = $db->query(
                "SELECT branchid FROM `branchlookup` where npfname = '$branch'"
            );
            $results = $query1->getResult();
            $branchid = $results[0]->branchid;
            $query1 = $db->query(
                "SELECT boardid FROM `boardlookup` where boardname = '$schoolboard'"
            );
            $results = $query1->getResult();
            $board = $results[0]->boardid;
            
            $query1 = $db->query(
                "SELECT courseid FROM `courselookup` where npfname = '$course'"
            );
            $results = $query1->getResult();
            $courseid = $results[0]->courseid;
            $query1 = $db->query(
                "SELECT admissiontypeid FROM `admissiontypelookup` where npfname = '$admissiontypeid'"
            );
            $results = $query1->getResult();
            $admissiontypeid = $results[0]->admissiontypeid;
            if($admissiontypeid == 5)
            {
                $admissiontypeid = 3;
            }
            if($admissiontypeid == 6)
            {
                $admissiontypeid = 1;
            }
            $categoryid = NULL;
            $religionid = NULL;
            $query1 = $db->query(
                "SELECT state_id FROM `stateslookup` where npfname = '$state'"
            );
            $results = $query1->getResult();
            $state = $results[0]->state_id;
            $query1 = $db->query(
                "SELECT district_id FROM `districtslookup` where district_name = '$district'"
            );
            $results = $query1->getResult();
            $district = $results[0]->district_id;
            if ($gender == "Male") {
                $genderid = 1;
            } elseif ($gender == "Female") {
                $genderid = 2;
            } else {
                $genderid = 3;
            }
            if(!empty($value->eligibility) &&  $value->eligibility== "Yes")
                    {
                        $eligibility = 2;
                    }elseif(!empty($value->eligibility) &&  $value->eligibility== "No")
                    {
                        $eligibility = 3;
                    }else
                    {
                        $eligibility = 1;
                    }
            $nationalityid = "";
            $parentoccupation = "";
            $visitorname = "";
            $relationwithstudent = "";
            $visitornumber = "";
            $previous_class_information = [];
            $class = [];
            $class["class"] = "PCI";
            $class["school"] = $value->schoolname;
            $class["board"] = $board;
            $class["place"] = $value->schooltown;
            $class["grade"] = "";
            $class["hallticketNo"] = "";
            array_push($previous_class_information, $class);

            $address = [];
            $permanent["door_street"] = $value->door_street;
            $permanent["village_mandal"] = $value->village_mandal;
            $permanent["landmark"] = "";
            $permanent["city_town"] = $value->city;
            $permanent["state"] = $state;
            $permanent["district"] = $district;
            $permanent["pin"] = $value->pin;
            $address["permanent"] = $permanent;
            $course = 1;
            $sectionid = 0;
            $secondlanguageid = "";
            $comments = "NPF";
            $referredby = 1;
            $batchid = 4;
            $admissiondate = date("Y-m-d");
            $reservationstatusid = 1;
            $scholarship = 0;
            $final_misc = 0;
            if ($applicationtype == 1) {
                $tuition_discount = null;
            } else {
                $tuition_discount =
                    isset($_POST["resofastfinalfee"]) &&
                    $_POST["resofastfinalfee"] != ""
                        ? $_POST["resofastfinalfee"]
                        : null;
            }
            $hostel_discount = null;
            $created_by = 1;
            $discountrequested =
                isset($_POST["discountrequested"]) &&
                $_POST["discountrequested"] != ""
                    ? $_POST["discountrequested"]
                    : null;
            $discountgiven =
                isset($_POST["discountgiven"]) && $_POST["discountgiven"] != ""
                    ? $_POST["discountgiven"]
                    : null;
            $address_json = json_encode($address);
            $previous_class_information_json = json_encode(
                $previous_class_information
            );

            $reservationModel = new ReservationModel();
            $insertId = $reservationModel->addApplicationUser(
                $application_ukey,
                $applicationtype,
                $name,
                $dateofbirth,
                $genderid,
                $nationalityid,
                $religionid,
                $categoryid,
                $studentaadhaar,
                $fathername,
                $mothername,
                $parentoccupation,
                $visitorname,
                $relationwithstudent,
                $visitornumber,
                $previous_class_information_json,
                $address_json,
                $mobile1,
                $mobile2,
                $email,
                $admissiontypeid,
                $branchid,
                $courseid,
                $course,
                $sectionid,
                $secondlanguageid,
                $comments,
                $referredby,
                $batchid,
                $admissiondate,
                $reservationstatusid,
                $eligibility,
                $scholarship,
                $tuition_discount,
                $hostel_discount,
                $final_misc,
                $discountrequested,
                $discountgiven,
                $created_by,
                $profile_image
            );
            $StudentDetailS = $reservationModel->getApplicationDetails(
                $insertId
            );
            $comm = new Comm();
            $data[0] = $mobile1;
            $data[1] = $StudentDetailS->name;
            $data[2] = $StudentDetailS->application_ukey;
            $data[3] = $StudentDetailS->branchname;
            $data[4] = "https://rb.gy/fjd7gn?id={$StudentDetailS->applicationid}";
            $comm->sendSMS("Newapplication", $data);
                        
            }else
            {
                if(!empty($value->counselorname))
                {
                    $mobile1 = $value->mobile;
                    $email = $value->email;
                    $counsellor = $value->counselorname;
                     $query1 = $db->query(
                    "SELECT userid FROM `counsellor_mapping` where name = '$counsellor' and is_active=1"
                );
                $results = $query1->getResult();
                $userid = $results[0]->userid;
                    $reservationModel = new ReservationModel();
                    $reservationModel->updateCounsellorname($mobile1,$email,$userid);
                }
                
                elseif(!empty($value->eligibility))
                {
                    $application_no = $value->application_no;
                    if($value->eligibility == "Yes")
                    {
                        $eligibility = 2;
                    }else
                    {
                        $eligibility = 3;
                    }
                    $reservationModel = new ReservationModel();
                    $reservationModel->updateEligibility($application_no,$eligibility);
                }
                
            }
            $response = [
                "status" => true,
                "data" => $value,
                "message" => "success",
            ];
            return $this->respondCreated($response);
        }
    }
    public function absentregularise()
    {
        $db = db_connect();
        $attendanceid = $this->request->getVar("attendanceid");
        $reason = $this->request->getVar("reason");
        $type = $this->request->getVar("type");
        $model = new ApiModel();
        $model->updateabsentregularise($attendanceid, $reason, $type);
        $response = [
            "status" => true,
            "message" => "success",
        ];
        return $this->respondCreated($response);
    }
     public function absentregulariselist()
    {
        $db = db_connect();
        $userid = $this->request->getVar("userid");
        $model = new ApiModel();
       $data = $model->absentregulariselist($userid);
        $response = [
            "status" => true,
            "data" => $data,
            "message" => "success",
        ];
        return $this->respondCreated($response);
    }
    public function approveabsentregularise()
    {
        $attendanceid = $this->request->getVar("attendanceid");
        $status = $this->request->getVar("status");
        $model = new ApiModel();
        $model->approveabsentregularise($attendanceid, $status);
        $response = [
            "status" => true,
            "message" => "success",
        ];
        return $this->respondCreated($response);
    }
    public function absenttype()
    {
        $data_array =  array(
            "type1"        => "Biometric Not Punched",
            "type2"        => "Outside Work"
            );
            $response = [
            "status" => true,
            "data" => $data_array,
            "message" => "success",
        ];
         return $this->respondCreated($response);
    }
    public function formapprovals()
    {
        $form = $this->request->getVar("form");
        $formsModel = new ApiModel();
        $formRequests = $formsModel->getFormRequests($form);
        foreach ($formRequests as $result) :
            $result->data = json_decode($result->data);
            
            if($form == "discountApproval")
            {
                $discountid = $result->data->discountid;
            
                 $db = db_connect();

            $query = $db->query("SELECT * FROM discountlookup 
                                 WHERE id = $discountid");
            $result1 = $query->getResultArray();
            $result->data->discountid = $result1[0]['discountname'];
            }
        endforeach;
        $response = [
            "status" => true,
            "data" => $formRequests,
            "message" => "success",
        ];
         return $this->respondCreated($response);
    }
    public function formRequestApproval()
    {
        $status = $this->request->getVar("status");
        $userid = $this->request->getVar("userid");
        $form_request_id =  $this->request->getVar("form_request_id");
        $refundAmount =  $this->request->getVar("refundAmount");
       
        if ($status == 1) {
             $main['status'] = "approved";
             $db = db_connect();

            $query = $db->query("SELECT Fr.data,Fr.form_type,Fr.user_id,Fr.batchid FROM form_requests Fr
                                 WHERE Fr.form_request_id = $form_request_id");
            $result = $query->getResultArray();
            $db->close();
            $data = json_decode($result[0]['data']);
             if($refundAmount != NULL || $refundAmount != ''){
                    if($result[0]['form_type']=="discountApproval")
                {
                    $data->Amount = $refundAmount;
                }else
                {
                    $data->RefundAmount = $refundAmount;
                }
                }
                $main['updated_timestamp'] = date('Y-m-d H:i:s');
                $main['updated_by'] = $userid;

                $main['data'] = json_encode($data);

                $builder = $db->table('form_requests');
                $builder->where('form_request_id', $form_request_id);
                $builder->update($main);
                if($result[0]['form_type']=="discountApproval")
                {
        //             $data1['userid'] = $result[0]['user_id'];
        // 			$data1['invoiceid'] = $data->InvoiceId;
        // 			$data1['invoice'] = 2;
        // 			$data1['batchid'] = $result[0]['batchid'];
        // 			$data1['feesid'] = 44;
        // 			$data1['feesvalue'] = -$data->Amount;
        // 			$data1['discountid'] = $data->discountid;
        // 			$data1['additionaldetails'] = $data->additionaldetails;
        
        // 			$paymentmodel = new PaymentsModel();
        // 			$paymentmodel->addInvoice($data1);
        
                    $userid = $result[0]['user_id'];
                    $paymenttypeid = 10;
                    $paymentamount = $data->Amount;
                    // $paymentdate = date_create_from_format("d/m/Y", $_POST['paymentdate']) != false ? date_format(date_create_from_format("d/m/Y", $_POST['paymentdate']), 'Y-m-d') : date('Y-m-d');
                    $paymentdate = date('Y-m-d');
                    $otherdetails = $data->discountid;
                    $remarks = $data->additionaldetails;
                    $invoice = $data->InvoiceId;
            		$paymentcollectedby = 1;
            		$paymentstatusid = 1;
            		$helperModel = new HelperModel();
            		$batch = $helperModel->get_batch()->year;
            		$nextpaymentid = $helperModel->get_paymentidcounter();
            		$paymentid = "RMD-" . $batch . "-" . str_pad($nextpaymentid, 6, '0', STR_PAD_LEFT);
                    $createddate = date('Y-m-d H:i:s');
                    $data1['updated_by'] = $userid;
                    $data1['paymentid'] = $paymentid;
                    $data1['userid'] = $userid;
                    $data1['invoice'] = $invoice;
                    $data1['paymentamount'] = $paymentamount;
                    $data1['paymentdate'] = $paymentdate;
                    $data1['paymenttypeid'] = $paymenttypeid;
                    $data1['otherdetails'] = $otherdetails;
                    $data1['paymentcollectedby'] = $paymentcollectedby;
                    $data1['paymentstatusid'] = $paymentstatusid;
                    $data1['batchid'] = $result[0]['batchid'];
                    $data1['remarks'] = $remarks;
                    $data1['createddate'] =  $createddate;
                    $builder = $db->table('payments');
                    return $builder->insert($data1);
                	$nextpaymentid = $helperModel->set_paymentidcounter();
            		$html = file_get_contents(base_url("payments/print_receipt?paymentid={$paymentid}&batchid={$_SESSION['activebatch']}"));
            		$paymentsModel->htmltopdf($html, 'save', $paymentid, 'R');
                }
        }else
        {
            $db = db_connect();
            $main['status'] = "rejected";
            $builder = $db->table('form_requests');
            $builder->where('form_request_id', $form_request_id);
            $builder->update($main);
        }
    }
    public function resignations()
    {
        $userid = $this->request->getVar("userid");
        $last_working_day = $this->request->getVar("last_working_day");
        $reason = $this->request->getVar("reason");
        $model = new ApiModel();
        $model->addresignation(
            $userid,
            $last_working_day,
            $reason
        );
        $response = [
            "status" => true,
            "message" => "success",
        ];
        return $this->respondCreated($response);
    }
    public function reimbursement()
    {
        $userid = $this->request->getVar("userid");
        $category = $this->request->getVar("category");
        $amount = $this->request->getVar("amount");
        $reason = $this->request->getVar("reason");
        $model = new ApiModel();
        $model->addreimbursement(
            $userid,
            $category,
            $amount,
            $reason
        );
        $response = [
            "status" => true,
            "message" => "success",
        ];
        return $this->respondCreated($response);
    }
    public function reimbursementtype()
    {
        $data_array =  array(
           "Travel",
            "Purchase",
            "Miscellaneous"
            );
            $response = [
            "status" => true,
            "data" => $data_array,
            "message" => "success",
        ];
         return $this->respondCreated($response);
    }
    public function reimbursementlist()
    {
        $db = db_connect();
        $userid = $this->request->getVar("userid");
        $model = new ApiModel();
        $Accounts = $model->get_reimbursement($userid);
        $response = [
            "status" => true,
            "data" => $Accounts,
            "message" => "success",
        ];
        return $this->respondCreated($response);
    }
    public function resignationlist()
    {
        $db = db_connect();
        $userid = $this->request->getVar("userid");
        $model = new ApiModel();
        $Accounts = $model->get_resignation($userid);
        $response = [
            "status" => true,
            "data" => $Accounts,
            "message" => "success",
        ];
        return $this->respondCreated($response);
    }
    public function resignationrequests()
    {
        $userid = $this->request->getVar("userid");
        if (!empty($userid)) {
            $model = new ApiModel();
            $data = $model->resignationrequestlist($userid);
            $response = [
                "status" => true,
                "data" => $data,
                "message" => "success",
            ];
            return $this->respondCreated($response);
        } else {
            $response = [
                "status" => false,
                "message" => "Enter Mandatory Fields",
            ];
            return $this->respondCreated($response);
        }
    }
    public function reimbursementrequests()
    {
        $userid = $this->request->getVar("userid");
        if (!empty($userid)) {
            $model = new ApiModel();
            $data = $model->reimbursementrequestlist($userid);
            $response = [
                "status" => true,
                "data" => $data,
                "message" => "success",
            ];
            return $this->respondCreated($response);
        } else {
            $response = [
                "status" => false,
                "message" => "Enter Mandatory Fields",
            ];
            return $this->respondCreated($response);
        }
    }
    public function returnapi()
    {
         $model = new ApiModel();
            $data = $model->Approvedapplicationlist(1);
            foreach($data as $a)
            {
           
                // User data to send using HTTP POST method in curl
        $data = array('email'=>$a->email,'application_no'=>$a->application_ukey, 'secret_key' => '7f553c6768790902c5f73d49db02746f','form_id'=>'18781','enrolled_field8'=> '1500691;;;Yes','mode'=>'update');
        
        // Data should be passed as json format
        $data_json = json_encode($data);
        // API URL to send data
        $url = 'https://api.in5.nopaperforms.com/form/post-application/5471/18781';
        
        // curl initiate
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, $url);
        
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        
        // SET Method as a POST
        curl_setopt($ch, CURLOPT_POST, 1);
        
        // Pass user data in POST command
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        // Execute curl and assign returned data
        $response  = curl_exec($ch);
        
        // Close curl
        curl_close($ch);
         $db = db_connect();
            $query1 = $db->query(
                "update applications set is_enrolled=1 where application_ukey = '$a->application_ukey'"
            );
            }
        // See response if data is posted successfully or any error
         $response = [
                "status" => true,
                "message" => "success"
            ];
            return $this->respondCreated($response);
    }
    public function approveresignation()
    {
        $resignationid = $this->request->getVar("resignationid");
        $status = $this->request->getVar("status");
        $userid = $this->request->getVar("userid");
        $model = new ApiModel();
        $model->approveresignation($resignationid, $status,$userid);
        $response = [
            "status" => true,
            "message" => "success",
        ];
        return $this->respondCreated($response);
    }
    public function approvereimbursement()
    {
        $reimbursementid = $this->request->getVar("reimbursementid");
        $status = $this->request->getVar("status");
        $userid = $this->request->getVar("userid");
        $model = new ApiModel();
        $model->approvereimbursement($reimbursementid, $status,$userid);
        $response = [
            "status" => true,
            "message" => "success",
        ];
        return $this->respondCreated($response);
    }
    public function financeresignationrequests()
    {
        $model = new ApiModel();
        $data = $model->financeresignationrequestlist();
        $response = [
            "status" => true,
            "data" => $data,
            "message" => "success",
        ];
        return $this->respondCreated($response);
    }
    public function hrresignationrequests()
    {
        $model = new ApiModel();
        $data = $model->hrresignationrequestlist();
        $response = [
            "status" => true,
            "data" => $data,
            "message" => "success",
        ];
        return $this->respondCreated($response);
    }
    public function hrreimbursementrequests()
    {
        $model = new ApiModel();
        $data = $model->hrreimbursementrequestlist();
        $response = [
            "status" => true,
            "data" => $data,
            "message" => "success",
        ];
        return $this->respondCreated($response);
    }
    public function financeapproveresignation()
    {
        $resignationid = $this->request->getVar("resignationid");
        $status = $this->request->getVar("status");
        $userid = $this->request->getVar("userid");
        $model = new ApiModel();
        $model->financeapproveresignation($resignationid, $status,$userid);
        $response = [
            "status" => true,
            "message" => "success",
        ];
        return $this->respondCreated($response);
    }
    public function hrapproveresignation()
    {
        $resignationid = $this->request->getVar("resignationid");
        $status = $this->request->getVar("status");
        $userid = $this->request->getVar("userid");
        $model = new ApiModel();
        $model->hrapproveresignation($resignationid, $status,$userid);
        $response = [
            "status" => true,
            "message" => "success",
        ];
        return $this->respondCreated($response);
    }
    public function hrapprovereimbursement()
    {
        $reimbursementid = $this->request->getVar("reimbursementid");
        $status = $this->request->getVar("status");
        $userid = $this->request->getVar("userid");
        $model = new ApiModel();
        $model->hrapprovereimbursement($reimbursementid, $status,$userid);
        $response = [
            "status" => true,
            "message" => "success",
        ];
        return $this->respondCreated($response);
    }
    public function Approvedapplicationlist()
    {
        $branchid = $this->request->getVar("branchid");
        $batchid = $this->request->getVar("batchid");
        $model = new ApiModel();
        $data = $model->Approvedapplicationlist($branchid,$batchid);
        $response = [
            "status" => true,
            "data" => $data,
            "message" => "success",
        ];
        return $this->respondCreated($response);
    }
    public function Studentlist()
    {
        $branchid = $this->request->getVar("branchid");
        $batchid = $this->request->getVar("batchid");
        $model = new ApiModel();
        $data = $model->Studentlist($branchid,$batchid);
        $response = [
            "status" => true,
            "data" => $data,
            "message" => "success",
        ];
        return $this->respondCreated($response);
    }
     public function Siblinglist()
    {
        $model = new ApiModel();
        $data = $model->Siblinglist();
        $response = [
            "status" => true,
            "data" => $data,
            "message" => "success",
        ];
        return $this->respondCreated($response);
    }
    public function discounttype()
    {
        $data_array =  array(
            "Sibling",
            "Application",
            "Referral"
            );
            $response = [
            "status" => true,
            "data" => $data_array,
            "message" => "success",
        ];
         return $this->respondCreated($response);
    }
    public function createreservationdiscount()
    {
        $reservationid = $this->request->getVar("reservationid");
        $userid = $this->request->getVar("userid");
        $amount = $this->request->getVar("amount");
        $amount1 = $this->request->getVar("amount1");
        $discounttype = $this->request->getVar("discounttype");
        $comments = $this->request->getVar("comments");
        $reason = $this->request->getVar("reason");
        $branchid = $this->request->getVar("branchid");
        $requested_to = $this->request->getVar("requested_to");
        $batchid = $this->request->getVar("batchid");
        $type = $this->request->getVar("type");
        if($type == "Student")
        {
            $type = 2;
        }elseif($type=="Reservation")
        {
            $type = 1;
        }
        $db = db_connect();
        $query12 = $db->query("SELECT batchlookup.batchname FROM `batchlookup` where batchid = '$batchid'");
        $results_d2 = $query12->getResult();
        
        $query1 = $db->query("SELECT count(*) as count FROM `reservation_discounts` where userid = '$reservationid' and type={$type}");
        $results_d = $query1->getResult();
        if($results_d[0]->count > 0)
        {
             $response = [
                "status" => false,
                "message" => "Already Voucher Discount request have been raised."
            ];
        }else{
        $model = new ApiModel();
        $nextdiscountid = $model->getdiscountidnew($branchid);
        $disid = $nextdiscountid->branchcode.'-('.$results_d2[0]->batchname.')-'.$nextdiscountid->reservation_discountid;
        $model->createreservationdiscount($reservationid, $amount,$amount1,$discounttype,$comments,$reason,$userid,$disid,$requested_to,$batchid,$type);
        $model->set_getdiscountid($branchid);
        $db = db_connect();
        $query1 = $db->query("SELECT name,firebase FROM `employeedetails` where userid = '$requested_to'");
        $results = $query1->getResult();
        $query2 = $db->query("SELECT name FROM `employeedetails` where userid = '$userid'");
        $results1 = $query2->getResult();
        $name = $results1[0]->name;
        $token = $results[0]->firebase;
            if ($token != "") {
                $description = "S-voucher from {$name} ";
                $message = "New S-voucher request";
                $google_api_key =
                    "AAAAVgjSTtk:APA91bHDVyLfnWLl4NzHOHA8oE8-vMdqUXSNs2Z016_ecAQKstmNj4aQztNcTY_WC6nj-zl0XkAux4OlTqMQDzKSlVkU5xpq0Ya-IpNC7LxiA95dzW9LIpg8YLK1G8JJ9Uhml-CzrAgr";
                $registrationIds = $token;
                #prep the bundle
                $msg = [
                    "body" => $description,
                    "title" => $message,
                    "sound" => 1 /*Default sound*/,
                ];

                $fields = [
                    "to" => $registrationIds,
                    "notification" => $msg,
                ];
                $headers = [
                    "Authorization: key=" . $google_api_key,
                    "Content-Type: application/json",
                ];
                #Send Reponse To FireBase Server
                $ch = curl_init();
                curl_setopt(
                    $ch,
                    CURLOPT_URL,
                    "https://fcm.googleapis.com/fcm/send"
                );
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
                $result = curl_exec($ch);
                curl_close($ch);
            }
        $response = [
            "status" => true,
            "message" => "success",
        ];
        }
        return $this->respondCreated($response);
    }
    public function reservationdiscountlist()
    {
        $db = db_connect();
        $userid = $this->request->getVar("userid");
        $batchid = $this->request->getVar("batchid");
        $model = new ApiModel();
        $Accounts = $model->get_reservationdiscountlist($userid,$batchid);
        $response = [
            "status" => true,
            "data" => $Accounts,
            "message" => "success",
        ];
        return $this->respondCreated($response);
    }
    public function reservationdiscountrequests()
    {
        $userid = $this->request->getVar("userid");
        $batchid = $this->request->getVar("batchid");
        $type = $this->request->getVar("type");
        $db = db_connect();
        $model = new ApiModel();
        if($type=="Reservation"){
            $Accounts = $model->get_reservationdiscountrequests($userid,$batchid);
        }elseif($type=="Student")
        {
             $Accounts = $model->get_studentdiscountrequests($userid,$batchid);   
        }
        $response = [
            "status" => true,
            "data" => $Accounts,
            "message" => "success",
        ];
        return $this->respondCreated($response);
    }
    public function reservationdiscounts()
    {
        $userid = $this->request->getVar("userid");
        $batchid = $this->request->getVar("batchid");
        $type = $this->request->getVar("type");
        $db = db_connect();
        $model = new ApiModel();
        if($type=="Reservation"){
            $Accounts = $model->get_reservationdiscounts($userid,$batchid);
        }else
        {
             $Accounts = $model->get_studentdiscounts($userid,$batchid);
        }
        $response = [
            "status" => true,
            "data" => $Accounts,
            "message" => "success",
        ];
        return $this->respondCreated($response);
    }
    public function employeelimit()
    {
        $userid = $this->request->getVar("userid");
        $model = new ApiModel();
        $limit = $model->employeediscountlimit($userid);
         $response = [
            "status" => true,
            "data" => $limit,
            "message" => "success",
        ];
        return $this->respondCreated($response);
    }
    public function postpayment()
    {
        
    	$db = db_connect();
	    $model = new ApiModel();
         $model = $model->approveddiscount();
        foreach($model as $res){
          
        
        //   $id = $this->request->getVar("id");
        // $status = $this->request->getVar("status");
        // $userid = $this->request->getVar("userid");
        // $studentid = $this->request->getVar("studentid");
        // $amount = $this->request->getVar("amount");
        // $amount1 = $this->request->getVar("amount1");
        // $comments = $this->request->getVar("comments");
        // $discounttype = $this->request->getVar("discounttype");
        // $voucherid = $this->request->getVar("voucherid");
        // $type = $this->request->getVar("type");
        // $batchid = $this->request->getVar("batchid");
        // $commentreason = $this->request->getVar("commentreason");
        // student payment discount
        $reservationid = $res->userid;
        $voucherid = $res->reservation_discountid;
        $batchid = $res->batchid;
		$paymenttypeid = 10;
		$userid = $res->requested_to;
		$paymentamount = $res->amount;
		// $paymentdate = date_create_from_format("d/m/Y", $_POST['paymentdate']) != false ? date_format(date_create_from_format("d/m/Y", $_POST['paymentdate']), 'Y-m-d') : date('Y-m-d');
		$paymentdate = "2024-02-16";
		$otherdetails = $res->discounttype;
		$remarks = $res->comments;
		$paymentcollectedby = 1;
		$paymentstatusid = 1;
		$helperModel = new HelperModel();
		$batch = $helperModel->get_batch()->year;
		$nextpaymentid = $helperModel->get_paymentidcounter();
		$reservation_paymentid = "RMD-" . $batch . "-" . str_pad($nextpaymentid, 6, '0', STR_PAD_LEFT);
        $paymentsModel = new PaymentsModel();
        $result = $paymentsModel->addStudentPayments($reservation_paymentid, $reservationid, $paymentamount, $paymentdate, $paymenttypeid, $otherdetails, $paymentcollectedby, $paymentstatusid, $batchid, $remarks,$voucherid,$userid);
        $nextpaymentid = $helperModel->set_paymentidcounter();
         	$db = db_connect();
         	$date= date('Y-m-d H:i:s');
         	$id = $res->id;
         	//echo "update reservation_discounts set status=1,approved_date='$date',approvedamount='$paymentamount',approved_by=$userid where id = '$id'";
         	$query123 = $db->query("update reservation_discounts set status=1,approved_date='$date',approvedamount='$paymentamount',approved_by=62 where id = '$id'");
			$query12 = $db->query("SELECT batchlookup.batchname FROM `batchlookup` where batchid = '$batchid'");
            $results_d2 = $query12->getResult();
            $usersModel = new UsersModel();
        	$StudentDetailS = $usersModel->getStudentDetails($reservationid, $batchid);
			$comm = new Comm();
            $data[0] = $StudentDetailS[0]->mobile1;
            $data[1] = $StudentDetailS[0]->name;
            $data[2] = $StudentDetailS[0]->applicationnumber;
            $data[3] = $StudentDetailS[0]->branchname;
            $data[5] = $results_d2[0]->batchname;
            $data[6] = $StudentDetailS[0]->packagename;
            $data[7] = $paymentamount;
            $data[4] ="rb.gy/o0uabr?rd={$reservation_paymentid}";
            $comm->sendSMS("ReservationDiscount", $data);
/*

        // reservation discount payment
        
        
        $reservationid = $res->userid;
        $voucherid = $res->reservation_discountid;
        $batchid = $res->batchid;
		$paymenttypeid = 10;
		$userid = $res->requested_to;
		$paymentamount = $res->amount;
		// $paymentdate = date_create_from_format("d/m/Y", $_POST['paymentdate']) != false ? date_format(date_create_from_format("d/m/Y", $_POST['paymentdate']), 'Y-m-d') : date('Y-m-d');
		$paymentdate = "2024-02-16";
		$otherdetails = $res->discounttype;
		$remarks = $res->comments;
		$paymentcollectedby = 1;
		$paymentstatusid = 1;

            //$reservationid = $studentid;
		//	$paymenttypeid = 10;
		//	$paymentamount = $amount;
			// $paymentdate = date_create_from_format("d/m/Y", $_POST['paymentdate']) != false ? date_format(date_create_from_format("d/m/Y", $_POST['paymentdate']), 'Y-m-d') : date('Y-m-d');
		//	$paymentdate = date('Y-m-d');
		//	$otherdetails = $discounttype;
		//	$remarks = $comments;
			//$paymentcollectedby = 1;
		//	$paymentstatusid = 1;
			$helperModel = new HelperModel();
			$batch = $helperModel->get_batch()->year;
			$nextpaymentid = $helperModel->get_paymentidcounter();
			$reservation_paymentid = "RMD-" . $batch . "-" . str_pad($nextpaymentid, 6, '0', STR_PAD_LEFT);
			$reservationModel = new ReservationModel();
			$result = $reservationModel->addReservationPaymentVoucher(
				$reservation_paymentid,
				$reservationid,
				62,
				$paymentamount,
				$paymentdate,
				$paymenttypeid,
				$otherdetails,
				$paymentcollectedby,
				$paymentstatusid,
				$batchid,
				$remarks,
				$voucherid
			);
// 		//	if ($result->resultID) {
			$nextpaymentid = $helperModel->set_paymentidcounter();
			$html = file_get_contents(base_url("payments/print_reservationdiscountreceipt?reservationpaymentid={$reservation_paymentid}&batchid={$batchid}&voucherid={$voucherid}"));
			$paymentsModel = new PaymentsModel();
			$paymentsModel->htmltopdf($html, 'save', $reservation_paymentid, 'RP');
			$StudentDetailS = $reservationModel->getReservationDetails($reservationid,$batchid);
                $comm = new Comm();
                $data[0] = $StudentDetailS->mobile1;
                $data[1] = $StudentDetailS->name;
                $data[2] = $StudentDetailS->reservation_ukey;
                $data[3] = $StudentDetailS->branchname;
                $data[5] = $StudentDetailS->batchname;
                $data[6] = $StudentDetailS->packagename;
                $data[7] = $paymentamount;
                $data[4] ="rb.gy/o0uabr?rd={$reservation_paymentid}";
                $comm->sendSMS("ReservationDiscount", $data);
                
                $date= date('Y-m-d H:i:s');
         	$id = $res->id;
// //          	//echo "update reservation_discounts set status=1,approved_date='$date',approvedamount='$paymentamount',approved_by=$userid where id = '$id'";
         	$query123 = $db->query("update reservation_discounts set status=1,approved_date='$date',approvedamount='$paymentamount',approved_by=62 where id = '$id'");
                
		     $reservationid = $res->userid;
        $voucherid = $res->reservation_discountid;
        $batchid = $res->batchid;
		$paymenttypeid = 10;
		$userid = $res->requested_to;
		$paymentamount = $res->amount1;
		// $paymentdate = date_create_from_format("d/m/Y", $_POST['paymentdate']) != false ? date_format(date_create_from_format("d/m/Y", $_POST['paymentdate']), 'Y-m-d') : date('Y-m-d');
		$paymentdate = "2024-02-16";
		$otherdetails = $res->discounttype;
		$remarks = $res->comments;
		$paymentcollectedby = 1;
		$paymentstatusid = 1;
			$helperModel = new HelperModel();
			$batch = $helperModel->get_batch()->year;
			$nextpaymentid = $helperModel->get_paymentidcounter();
			$reservation_paymentid = "RMD-" . $batch . "-" . str_pad($nextpaymentid, 6, '0', STR_PAD_LEFT);
			$reservationModel = new ReservationModel();
			$result = $reservationModel->addReservationPaymentVoucher(
				$reservation_paymentid,
				$reservationid,
				62,
				$paymentamount,
				$paymentdate,
				$paymenttypeid,
				$otherdetails,
				$paymentcollectedby,
				$paymentstatusid,
				5,
				$remarks,
				$voucherid
			);
			$batchid = $batchid+1;
		//	if ($result->resultID) {
			$nextpaymentid = $helperModel->set_paymentidcounter();
			$html = file_get_contents(base_url("payments/print_reservationdiscountreceipt?reservationpaymentid={$reservation_paymentid}&batchid={$batchid}&voucherid={$voucherid}"));
			$paymentsModel = new PaymentsModel();
			$paymentsModel->htmltopdf($html, 'save', $reservation_paymentid, 'RP');
			
			//$StudentDetailS = $reservationModel->getReservationDetails($reservationid,5);
			$comm = new Comm();
                $data[0] = $StudentDetailS->mobile1;
                $data[1] = $StudentDetailS->name;
                $data[2] = $StudentDetailS->reservation_ukey;
                $data[3] = $StudentDetailS->branchname;
                $data[5] = "2025-26";
                $data[6] = $StudentDetailS->packagename;
                $data[7] = $paymentamount;
                $data[4] ="rb.gy/o0uabr?rd={$reservation_paymentid}";
                $comm->sendSMS("ReservationDiscount", $data);
                
                $date= date('Y-m-d H:i:s');
         	$id = $res->id;
//          	//echo "update reservation_discounts set status=1,approved_date='$date',approvedamount='$paymentamount',approved_by=$userid where id = '$id'";
         	$query123 = $db->query("update reservation_discounts set status=1,approved_date='$date',approvedamount1='$paymentamount',approved_by=62 where id = '$id'");
                */
                
        	$query1 = $db->query("SELECT created_by FROM `reservation_discounts` where id = '$id'");
            $results_d = $query1->getResult();
            $created_by = $results_d[0]->created_by;
            $query1 = $db->query("SELECT name,firebase FROM `employeedetails` where userid = '$created_by'");
            $results = $query1->getResult();
            $token = $results[0]->firebase;
            if ($token != "") {
                $description = "S-voucher Requested have been approved";
                $message = "S-voucher";
                $google_api_key =
                    "AAAAVgjSTtk:APA91bHDVyLfnWLl4NzHOHA8oE8-vMdqUXSNs2Z016_ecAQKstmNj4aQztNcTY_WC6nj-zl0XkAux4OlTqMQDzKSlVkU5xpq0Ya-IpNC7LxiA95dzW9LIpg8YLK1G8JJ9Uhml-CzrAgr";
                $registrationIds = $token;
                #prep the bundle
                $msg = [
                    "body" => $description,
                    "title" => $message,
                    "sound" => 1 /*Default sound*/,
                ];

                $fields = [
                    "to" => $registrationIds,
                    "notification" => $msg,
                ];
                $headers = [
                    "Authorization: key=" . $google_api_key,
                    "Content-Type: application/json",
                ];
                #Send Reponse To FireBase Server
                $ch = curl_init();
                curl_setopt(
                    $ch,
                    CURLOPT_URL,
                    "https://fcm.googleapis.com/fcm/send"
                );
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
                $result = curl_exec($ch);
                curl_close($ch);
            }
        }
         
    }
    public function approvereservationdiscount()
    {
    	$db = db_connect();
        $id = $this->request->getVar("id");
        $status = $this->request->getVar("status");
        $userid = $this->request->getVar("userid");
        $studentid = $this->request->getVar("studentid");
        $amount = $this->request->getVar("amount");
        $amount1 = $this->request->getVar("amount1");
        $comments = $this->request->getVar("comments");
        $discounttype = $this->request->getVar("discounttype");
        $voucherid = $this->request->getVar("voucherid");
        $type = $this->request->getVar("type");
        $batchid = $this->request->getVar("batchid");
        $commentreason = $this->request->getVar("commentreason");
        $model = new ApiModel();
        
        $model->approvereservationdiscount($id, $status,$userid,$studentid,$amount,$amount1,$comments,$commentreason);
         if($status == 1){
        if($type=="Reservation"){
            $reservationid = $studentid;
			$paymenttypeid = 10;
			$paymentamount = $amount;
			// $paymentdate = date_create_from_format("d/m/Y", $_POST['paymentdate']) != false ? date_format(date_create_from_format("d/m/Y", $_POST['paymentdate']), 'Y-m-d') : date('Y-m-d');
			$paymentdate = date('Y-m-d');
			$otherdetails = $discounttype;
			$remarks = $comments;
			$paymentcollectedby = 1;
			$paymentstatusid = 1;
			$helperModel = new HelperModel();
			$batch = $helperModel->get_batch()->year;
			$nextpaymentid = $helperModel->get_paymentidcounter();
			$reservation_paymentid = "RMD-" . $batch . "-" . str_pad($nextpaymentid, 6, '0', STR_PAD_LEFT);
			$reservationModel = new ReservationModel();
			$result = $reservationModel->addReservationPaymentVoucher(
				$reservation_paymentid,
				$reservationid,
				$userid,
				$paymentamount,
				$paymentdate,
				$paymenttypeid,
				$otherdetails,
				$paymentcollectedby,
				$paymentstatusid,
				$batchid,
				$remarks,
				$voucherid
			);
		//	if ($result->resultID) {
			$nextpaymentid = $helperModel->set_paymentidcounter();
			$html = file_get_contents(base_url("payments/print_reservationdiscountreceipt?reservationpaymentid={$reservation_paymentid}&batchid={$batchid}&voucherid={$voucherid}"));
			$paymentsModel = new PaymentsModel();
			$paymentsModel->htmltopdf($html, 'save', $reservation_paymentid, 'RP');
			$StudentDetailS = $reservationModel->getReservationDetails($reservationid,$batchid);
                $comm = new Comm();
                $data[0] = $StudentDetailS->mobile1;
                $data[1] = $StudentDetailS->name;
                $data[2] = $StudentDetailS->reservation_ukey;
                $data[3] = $StudentDetailS->branchname;
                $data[5] = $StudentDetailS->batchname;
                $data[6] = $StudentDetailS->packagename;
                $data[7] = $paymentamount;
                $data[4] ="rb.gy/o0uabr?rd={$reservation_paymentid}";
                $comm->sendSMS("ReservationDiscount", $data);
		    $reservationid = $studentid;
			$paymenttypeid = 10;
			$paymentamount = $amount1;
			// $paymentdate = date_create_from_format("d/m/Y", $_POST['paymentdate']) != false ? date_format(date_create_from_format("d/m/Y", $_POST['paymentdate']), 'Y-m-d') : date('Y-m-d');
			$paymentdate = date('Y-m-d');
			$otherdetails = $discounttype;
			$remarks = $comments;
			$paymentcollectedby = 1;
			$paymentstatusid = 1;
			$helperModel = new HelperModel();
			$batch = $helperModel->get_batch()->year;
			$nextpaymentid = $helperModel->get_paymentidcounter();
			$reservation_paymentid = "RMD-" . $batch . "-" . str_pad($nextpaymentid, 6, '0', STR_PAD_LEFT);
			$reservationModel = new ReservationModel();
			$result = $reservationModel->addReservationPaymentVoucher(
				$reservation_paymentid,
				$reservationid,
				$userid,
				$paymentamount,
				$paymentdate,
				$paymenttypeid,
				$otherdetails,
				$paymentcollectedby,
				$paymentstatusid,
				5,
				$remarks,
				$voucherid
			);
			$batchid = $batchid+1;
		//	if ($result->resultID) {
			$nextpaymentid = $helperModel->set_paymentidcounter();
			$html = file_get_contents(base_url("payments/print_reservationdiscountreceipt?reservationpaymentid={$reservation_paymentid}&batchid={$batchid}&voucherid={$voucherid}"));
			$paymentsModel = new PaymentsModel();
			$paymentsModel->htmltopdf($html, 'save', $reservation_paymentid, 'RP');
			
			//$StudentDetailS = $reservationModel->getReservationDetails($reservationid,5);
			$comm = new Comm();
                $data[0] = $StudentDetailS->mobile1;
                $data[1] = $StudentDetailS->name;
                $data[2] = $StudentDetailS->reservation_ukey;
                $data[3] = $StudentDetailS->branchname;
                $data[5] = "2025-26";
                $data[6] = $StudentDetailS->packagename;
                $data[7] = $paymentamount;
                $data[4] ="rb.gy/o0uabr?rd={$reservation_paymentid}";
                $comm->sendSMS("ReservationDiscount", $data);
        }elseif($type == "Student")
        {
            
            $reservationid = $studentid;
			$paymenttypeid = 10;
			$paymentamount = $amount;
			// $paymentdate = date_create_from_format("d/m/Y", $_POST['paymentdate']) != false ? date_format(date_create_from_format("d/m/Y", $_POST['paymentdate']), 'Y-m-d') : date('Y-m-d');
			$paymentdate = date('Y-m-d');
			$otherdetails = $discounttype;
			$remarks = $comments;
			$paymentcollectedby = 1;
			$paymentstatusid = 1;
			$helperModel = new HelperModel();
			$batch = $helperModel->get_batch()->year;
			$nextpaymentid = $helperModel->get_paymentidcounter();
			$reservation_paymentid = "RMD-" . $batch . "-" . str_pad($nextpaymentid, 6, '0', STR_PAD_LEFT);
            $paymentsModel = new PaymentsModel();
            $result = $paymentsModel->addStudentPayments($reservation_paymentid, $reservationid, $paymentamount, $paymentdate, $paymenttypeid, $otherdetails, $paymentcollectedby, $paymentstatusid, $batchid, $remarks,$voucherid,$userid);
            $nextpaymentid = $helperModel->set_paymentidcounter();
			$html = file_get_contents(base_url("payments/print_reservationdiscountreceipt?paymentid={$reservation_paymentid}&batchid={$batchid}&voucherid={$voucherid}"));
			$paymentsModel = new PaymentsModel();
			$paymentsModel->htmltopdf($html, 'save', $reservation_paymentid, 'RP');
			$db = db_connect();
			$query12 = $db->query("SELECT batchlookup.batchname FROM `batchlookup` where batchid = '$batchid'");
            $results_d2 = $query12->getResult();
            $usersModel = new UsersModel();
        	$StudentDetailS = $usersModel->getStudentDetails($studentid, $batchid);
			$comm = new Comm();
                $data[0] = $StudentDetailS[0]->mobile1;
                $data[1] = $StudentDetailS[0]->name;
                $data[2] = $StudentDetailS[0]->applicationnumber;
                $data[3] = $StudentDetailS[0]->branchname;
                $data[5] = $results_d2[0]->batchname;
                $data[6] = $StudentDetailS[0]->packagename;
                $data[7] = $paymentamount;
                $data[4] ="rb.gy/o0uabr?rd={$reservation_paymentid}";
                $comm->sendSMS("ReservationDiscount", $data);
            
        }
    		$db = db_connect();
    		$query1 = $db->query("SELECT created_by FROM `reservation_discounts` where id = '$id'");
            $results_d = $query1->getResult();
            $created_by = $results_d[0]->created_by;
            $query1 = $db->query("SELECT name,firebase FROM `employeedetails` where userid = '$created_by'");
            $results = $query1->getResult();
            $token = $results[0]->firebase;
            if ($token != "") {
                $description = "S-voucher Requested have been approved";
                $message = "S-voucher";
                $google_api_key =
                    "AAAAVgjSTtk:APA91bHDVyLfnWLl4NzHOHA8oE8-vMdqUXSNs2Z016_ecAQKstmNj4aQztNcTY_WC6nj-zl0XkAux4OlTqMQDzKSlVkU5xpq0Ya-IpNC7LxiA95dzW9LIpg8YLK1G8JJ9Uhml-CzrAgr";
                $registrationIds = $token;
                #prep the bundle
                $msg = [
                    "body" => $description,
                    "title" => $message,
                    "sound" => 1 /*Default sound*/,
                ];

                $fields = [
                    "to" => $registrationIds,
                    "notification" => $msg,
                ];
                $headers = [
                    "Authorization: key=" . $google_api_key,
                    "Content-Type: application/json",
                ];
                #Send Reponse To FireBase Server
                $ch = curl_init();
                curl_setopt(
                    $ch,
                    CURLOPT_URL,
                    "https://fcm.googleapis.com/fcm/send"
                );
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
                $result = curl_exec($ch);
                curl_close($ch);
            }
                
         }
        $response = [
            "status" => true,
            "message" => "success",
        ];
        return $this->respondCreated($response);
    }
    public function reservationmaxdiscount()
    {
        $admissiontypeid = $this->request->getVar("admissiontypeid");
        $batchid = $this->request->getVar("batchid");
        $branchid = $this->request->getVar("branchid");
        $courseid = $this->request->getVar("courseid");
        $reservationid = $this->request->getVar("reservationid");
        
        $model = new ApiModel();
        $limit = $model->reservationmaxdiscount($admissiontypeid, $batchid,$branchid,$courseid);
        $response = [
            "status" => true,
            "data" => $limit,
            "message" => "success"
        ];
        return $this->respondCreated($response);
    }
    public function reservationmaxdiscountbyuserid()
    {
        $userid = $this->request->getVar("userid");
        $batchid = $this->request->getVar("batchid");
        $model = new ApiModel();
        $limit = $model->reservationmaxdiscountbyuserid($userid,$batchid);
        $response = [
            "status" => true,
            "data" => $limit,
            "message" => "success",
        ];
        return $this->respondCreated($response);
    }
    public function reservationdiscountto()
    {
        $model = new ApiModel();
        $limit = $model->reservationdiscountto();
        $response = [
            "status" => true,
            "data" => $limit,
            "message" => "success",
        ];
        return $this->respondCreated($response);
    }
    public function createfvoucher()
    {
        $reservationid = $this->request->getVar("reservationid");
        $userid = $this->request->getVar("userid");
        $amount = $this->request->getVar("amount");
        $reason = $this->request->getVar("reason");
        $branchid = $this->request->getVar("branchid");
        $requested_to = $this->request->getVar("requested_to");
        $batchid = $this->request->getVar("batchid");
        $type = $this->request->getVar("type");
        if($type == "Student")
        {
            $type = 2;
        }elseif($type=="Reservation")
        {
            $type = 1;
        }
        $db = db_connect();
        $query12 = $db->query("SELECT batchlookup.batchname FROM `batchlookup` where batchid = '$batchid'");
        $results_d2 = $query12->getResult();
        $query1 = $db->query("SELECT count(*) as count FROM `reservation_discounts` where userid = '$reservationid' and type={$type}");
        $results_d = $query1->getResult();
        if($results_d[0]->count > 0)
        {
             $response = [
                "status" => false,
                "message" => "Already Voucher Discount request have been raised."
            ];
        }else{
        $model = new ApiModel();
        $nextdiscountid = $model->getfvoucheridnew($branchid);
        $disid = $nextdiscountid->branchcode.'-('.$results_d2[0]->batchname.')-'.$nextdiscountid->fvoucherid;
        $model->createfvoucherdiscount($reservationid,$amount,$reason,$userid,$disid,$requested_to,$batchid,$type);
        $model->set_fvoucherid($branchid);
        
        $db = db_connect();
        $query1 = $db->query("SELECT name,firebase FROM `employeedetails` where userid = '$requested_to'");
        $results = $query1->getResult();
        $query2 = $db->query("SELECT name FROM `employeedetails` where userid = '$userid'");
        $results1 = $query2->getResult();
        $name = $results1[0]->name;
        $token = $results[0]->firebase;
            if ($token != "") {
                $description = "F-voucher from {$name} ";
                $message = "New F-voucher request";
                $google_api_key =
                    "AAAAVgjSTtk:APA91bHDVyLfnWLl4NzHOHA8oE8-vMdqUXSNs2Z016_ecAQKstmNj4aQztNcTY_WC6nj-zl0XkAux4OlTqMQDzKSlVkU5xpq0Ya-IpNC7LxiA95dzW9LIpg8YLK1G8JJ9Uhml-CzrAgr";
                $registrationIds = $token;
                #prep the bundle
                $msg = [
                    "body" => $description,
                    "title" => $message,
                    "sound" => 1 /*Default sound*/,
                ];

                $fields = [
                    "to" => $registrationIds,
                    "notification" => $msg,
                ];
                $headers = [
                    "Authorization: key=" . $google_api_key,
                    "Content-Type: application/json",
                ];
                #Send Reponse To FireBase Server
                $ch = curl_init();
                curl_setopt(
                    $ch,
                    CURLOPT_URL,
                    "https://fcm.googleapis.com/fcm/send"
                );
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
                $result = curl_exec($ch);
                curl_close($ch);
            }
        
        $response = [
            "status" => true,
            "message" => "success",
        ];
        }
        return $this->respondCreated($response);
    }
    public function fvoucherlist()
    {
        $db = db_connect();
        $userid = $this->request->getVar("userid");
        $batchid = $this->request->getVar("batchid");
        $model = new ApiModel();
        $Accounts = $model->get_fvoucherlist($userid,$batchid);
        $response = [
            "status" => true,
            "data" => $Accounts,
            "message" => "success",
        ];
        return $this->respondCreated($response);
    }
    public function fvoucherrequests()
    {
        $userid = $this->request->getVar("userid");
        $batchid = $this->request->getVar("batchid");
        $type = $this->request->getVar("type");
        $db = db_connect();
        $model = new ApiModel();
       if($type=="Reservation"){
        $Accounts = $model->get_fvoucherrequests($userid,$batchid);
       }else
       {
           $Accounts = $model->get_studentfvoucherrequests($userid,$batchid);
       }
        $response = [
            "status" => true,
            "data" => $Accounts,
            "message" => "success",
        ];
        return $this->respondCreated($response);
    }
     public function approvefvoucher()
    {
        $id = $this->request->getVar("id");
        $status = $this->request->getVar("status");
        $userid = $this->request->getVar("userid");
        $studentid = $this->request->getVar("studentid");
        $amount = $this->request->getVar("amount");
        $reason = $this->request->getVar("reason");
        $comments = $this->request->getVar("comments");
        $voucherid = $this->request->getVar("voucherid");
        $type = $this->request->getVar("type");
        $commentreason = $this->request->getVar("commentreason");
        $batchid = $this->request->getVar("batchid");
        $model = new ApiModel();
        $model->approvefvoucher($id, $status,$userid,$studentid,$amount,$comments,$commentreason);
         if($status == 1){
        if($type=="Reservation"){
        $reservationid = $studentid;
			$paymenttypeid = 11;
			$paymentamount = $amount;
			// $paymentdate = date_create_from_format("d/m/Y", $_POST['paymentdate']) != false ? date_format(date_create_from_format("d/m/Y", $_POST['paymentdate']), 'Y-m-d') : date('Y-m-d');
			$paymentdate = date('Y-m-d');
			$otherdetails = $comments;
			$remarks = $reason;
			$paymentcollectedby = 1;
			$paymentstatusid = 1;
			$helperModel = new HelperModel();
			$batch = $helperModel->get_batch()->year;
			$nextpaymentid = $helperModel->get_paymentidcounter();
			$reservation_paymentid = "RMD-" . $batch . "-" . str_pad($nextpaymentid, 6, '0', STR_PAD_LEFT);
			$reservationModel = new ReservationModel();
			$result = $reservationModel->addReservationPaymentVoucher(
				$reservation_paymentid,
				$reservationid,
				$userid,
				$paymentamount,
				$paymentdate,
				$paymenttypeid,
				$otherdetails,
				$paymentcollectedby,
				$paymentstatusid,
				4,
				$remarks,
				$voucherid
			);
		//	if ($result->resultID) {
				$nextpaymentid = $helperModel->set_paymentidcounter();
				$html = file_get_contents(base_url("payments/print_reservationreceipt?reservationpaymentid={$reservation_paymentid}&batchid={$batchid}"));
				$paymentsModel = new PaymentsModel();
				$paymentsModel->htmltopdf($html, 'save', $reservation_paymentid, 'RP');
        }elseif($type == "Student")
        {
             $reservationid = $studentid;
			$paymenttypeid = 11;
			$paymentamount = $amount;
			// $paymentdate = date_create_from_format("d/m/Y", $_POST['paymentdate']) != false ? date_format(date_create_from_format("d/m/Y", $_POST['paymentdate']), 'Y-m-d') : date('Y-m-d');
			$paymentdate = date('Y-m-d');
			$otherdetails = $discounttype;
			$remarks = $comments;
			$paymentcollectedby = 1;
			$paymentstatusid = 1;
			$helperModel = new HelperModel();
			$batch = $helperModel->get_batch()->year;
			$nextpaymentid = $helperModel->get_paymentidcounter();
			$reservation_paymentid = "RMD-" . $batch . "-" . str_pad($nextpaymentid, 6, '0', STR_PAD_LEFT);
            $paymentsModel = new PaymentsModel();
            $result = $paymentsModel->addStudentPayments($reservation_paymentid, $reservationid, $paymentamount, $paymentdate, $paymenttypeid, $otherdetails, $paymentcollectedby, $paymentstatusid, $batchid, $remarks,$voucherid,$userid);
       
        }
         }
        $response = [
            "status" => true,
            "message" => "success",
        ];
        return $this->respondCreated($response);
    }
    public function getapplicationscount()
    {
        $db = db_connect();
        $userid = $this->request->getVar("userid");
        $batchid = $this->request->getVar("batchid");
        $branchid = $this->request->getVar("branchid");
        $query = $db->query("SELECT applicationid count from applications where  reservationstatusid=4 and branchid in ({$branchid}) and batchid IN ({$batchid})");
        $results = $query->getResult();
        $bg = count($results);
        $query1 = $db->query("SELECT applicationid from applications where  reservationstatusid=5 and branchid in ({$branchid}) and batchid IN ({$batchid})");
        $results1 = $query1->getResult();
        $bg1 = count($results1);
        $querytotal = $db->query("SELECT applicationid count from applications where  branchid in ({$branchid}) and batchid IN ({$batchid})");
        $resultstotal = $querytotal->getResult();
        $bg2 = count($resultstotal);
        $querytotalpen = $db->query("SELECT applicationid count from applications where reservationstatusid=1 and branchid in ({$branchid}) and batchid IN ({$batchid})");
        $resultstotalpen = $querytotalpen->getResult();
        $bg3 = count($resultstotalpen);
        
         $data_array[] =  array(
            "Total"        => $bg2,
            "Pending"        => $bg3,
            "Approved"        => $bg,
            "Confirmed"        => $bg1
            );
            
        $response = [
            "status" => true,
            "data" => $data_array,
            "message" => "success",
        ];
        return $this->respondCreated($response);
    }
    public function Applications()
    {
        $db = db_connect();
        $userid = $this->request->getVar("userid");
        $roleid = $this->request->getVar("roleid");
        $batchid = $this->request->getVar("batchid");
        $branchid = $this->request->getVar("branchid");
        $applicationstatus = $this->request->getVar("applicationstatus");
        if($applicationstatus == "Total")
        {
            $applicationstatus = "1,2,3,4,5";
        }elseif($applicationstatus == "Pending")
        {
            $applicationstatus = 1;
        }elseif($applicationstatus == "Confirmed")
        {
            $applicationstatus = 5;
        }elseif($applicationstatus == "Approved")
        {
            $applicationstatus = 4;
        }
        $model = new ApiModel();
        if($userid==7181)
        {
            $reservations = $model->get_allapplications($batchid,$applicationstatus);
        }
        elseif($roleid==15){
            $reservations = $model->get_agentapplications($userid,$batchid,$applicationstatus);
        }else if($roleid==3)
        {
            $reservations = $model->get_applications($branchid,$batchid,$applicationstatus);
        }
        else if($roleid==1)
        {
            $reservations = $model->get_allapplications($batchid,$applicationstatus);
        }
        else
        {
            $reservations = $model->get_myapplications($userid,$batchid,$applicationstatus);
        }
        $response = [
            "status" => true,
            "data" => $reservations,
            "message" => "success",
        ];
        return $this->respondCreated($response);
    }
    public function getApplicationPaymentLinks()
    {
        $userid = $this->request->getVar("userid");
        $batchid = $this->request->getVar("batchid");
        $db = db_connect();
        $query = $db->query("SELECT url FROM applicationpayment_links  
                             WHERE userid = $userid and batchid IN ({$batchid}) order by paymentlinkid desc");
        $results = $query->getResult();
        if(empty($results)){
            $query = $db->query("SELECT url FROM applicationpayment_links  
                             WHERE userid = 1 and batchid IN (4) order by paymentlinkid desc");
        $results = $query->getResult();
        }
       
        
        $db->close();
        $response = [
            "status" => true,
            "data" => $results,
            "message" => "success",
        ];
        return $this->respondCreated($response);
    }
    public function getbranch()
    {
        $db = db_connect();
        $userid = $this->request->getVar("userid");
        $model = new ApiModel();
        $Accounts = $model->get_Branches($userid);
        $response = [
            "status" => true,
            "data" => $Accounts,
            "message" => "success",
        ];
        return $this->respondCreated($response);
    }
    public function getbatch()
    {
        $db = db_connect();
        $model = new ApiModel();
        $Accounts = $model->get_Batch();
        $response = [
            "status" => true,
            "data" => $Accounts,
            "message" => "success",
        ];
        return $this->respondCreated($response);
    }
    public function createevoucher()
    {
        $reservationid = $this->request->getVar("reservationid");
        $userid = $this->request->getVar("userid");
        $amount = $this->request->getVar("amount");
        $reason = $this->request->getVar("reason");
        $comments = $this->request->getVar("comments");
        $branchid = $this->request->getVar("branchid");
        $requested_to = $this->request->getVar("requested_to");
        $batchid = $this->request->getVar("batchid");
        $type = $this->request->getVar("type");
        if($type == "Student")
        {
            $type = 2;
        }elseif($type=="Reservation")
        {
            $type = 1;
        }
        $db = db_connect();
        $query12 = $db->query("SELECT batchlookup.batchname FROM `batchlookup` where batchid = '$batchid'");
        $results_d2 = $query12->getResult();
        $query1 = $db->query("SELECT count(*) as count FROM `reservation_discounts` where userid = '$reservationid' and type={$type}");
        $results_d = $query1->getResult();
        if($results_d[0]->count > 0)
        {
             $response = [
                "status" => false,
                "message" => "Previous voucher request is pending for approval."
            ];
        }else{
            $model = new ApiModel();
            $nextdiscountid = $model->getevoucheridnew($branchid);
            $disid = $nextdiscountid->branchcode.'-('.$results_d2[0]->batchname.')-'.$nextdiscountid->evoucherid;
            $model->createevoucherdiscount($reservationid,$amount,$reason,$comments,$userid,$disid,$requested_to,$batchid,$type);
            $model->set_evoucherid($branchid);
            $response = [
                "status" => true,
                "message" => "success",
            ];
        }
        return $this->respondCreated($response);
    }
    public function evoucherlist()
    {
        $db = db_connect();
        $userid = $this->request->getVar("userid");
        $batchid = $this->request->getVar("batchid");
        $model = new ApiModel();
        $Accounts = $model->get_evoucherlist($userid,$batchid);
        $response = [
            "status" => true,
            "data" => $Accounts,
            "message" => "success",
        ];
        return $this->respondCreated($response);
    }
    public function evoucherrequests()
    {
        $userid = $this->request->getVar("userid");
        $batchid = $this->request->getVar("batchid");
        $type = $this->request->getVar("type");
        $db = db_connect();
        $model = new ApiModel();
        if($type=="Reservation"){
        $Accounts = $model->get_evoucherrequests($userid,$batchid);
        }else
        {
            $Accounts = $model->get_studentevoucherrequests($userid,$batchid);
        }
        $response = [
            "status" => true,
            "data" => $Accounts,
            "message" => "success",
        ];
        return $this->respondCreated($response);
    }
     public function approveevoucher()
    {
        $id = $this->request->getVar("id");
        $status = $this->request->getVar("status");
        $userid = $this->request->getVar("userid");
        $studentid = $this->request->getVar("studentid");
        $amount = $this->request->getVar("amount");
        $reason = $this->request->getVar("reason");
        $comments = $this->request->getVar("comments");
        $voucherid = $this->request->getVar("voucherid");
        $type = $this->request->getVar("type");
        $commentreason = $this->request->getVar("commentreason");
        $batchid = $this->request->getVar("batchid");
        $model = new ApiModel();
        $model->approveevoucher($id, $status,$userid,$studentid,$amount,$comments,$commentreason);
         if($status == 1){
        if($type=="Reservation"){
        $reservationid = $studentid;
			$paymenttypeid = 12;
			$paymentamount = $amount;
			// $paymentdate = date_create_from_format("d/m/Y", $_POST['paymentdate']) != false ? date_format(date_create_from_format("d/m/Y", $_POST['paymentdate']), 'Y-m-d') : date('Y-m-d');
			$paymentdate = date('Y-m-d');
			$otherdetails = $comments;
			$remarks = $reason;
			$paymentcollectedby = 1;
			$paymentstatusid = 1;
			$helperModel = new HelperModel();
			$batch = $helperModel->get_batch()->year;
			$nextpaymentid = $helperModel->get_paymentidcounter();
			$reservation_paymentid = "RMD-" . $batch . "-" . str_pad($nextpaymentid, 6, '0', STR_PAD_LEFT);
			$reservationModel = new ReservationModel();
			$result = $reservationModel->addReservationPaymentVoucher(
				$reservation_paymentid,
				$reservationid,
				$userid,
				$paymentamount,
				$paymentdate,
				$paymenttypeid,
				$otherdetails,
				$paymentcollectedby,
				$paymentstatusid,
				4,
				$remarks,
				$voucherid
			);
		//	if ($result->resultID) {
				$nextpaymentid = $helperModel->set_paymentidcounter();
				$html = file_get_contents(base_url("payments/print_reservationreceipt?reservationpaymentid={$reservation_paymentid}&batchid={$batchid}"));
				$paymentsModel = new PaymentsModel();
				$paymentsModel->htmltopdf($html, 'save', $reservation_paymentid, 'RP');
         }elseif($type == "Student")
         {
             
             $reservationid = $studentid;
			$paymenttypeid = 12;
			$paymentamount = $amount;
			// $paymentdate = date_create_from_format("d/m/Y", $_POST['paymentdate']) != false ? date_format(date_create_from_format("d/m/Y", $_POST['paymentdate']), 'Y-m-d') : date('Y-m-d');
			$paymentdate = date('Y-m-d');
			$otherdetails = $reason;
			$remarks = $comments;
			$paymentcollectedby = 1;
			$paymentstatusid = 1;
			$helperModel = new HelperModel();
			$batch = $helperModel->get_batch()->year;
			$nextpaymentid = $helperModel->get_paymentidcounter();
			$reservation_paymentid = "RMD-" . $batch . "-" . str_pad($nextpaymentid, 6, '0', STR_PAD_LEFT);
            $paymentsModel = new PaymentsModel();
            $result = $paymentsModel->addStudentPayments($reservation_paymentid, $reservationid, $paymentamount, $paymentdate, $paymenttypeid, $otherdetails, $paymentcollectedby, $paymentstatusid, $batchid , $remarks,$voucherid,$userid);
       
         }
         }
        $response = [
            "status" => true,
            "message" => "success",
        ];
        return $this->respondCreated($response);
    }
    public function retstatuschanged()
    {
        $db = db_connect();
    	$id = $this->request->getVar("applicationid");
    	$status = $this->request->getVar("retstatus");
        $reservationModel = new ReservationModel();
        $reservationModel->updateRETstatus($id, $status);
        $response = [
            "status" => true,
            "message" => "success",
        ];
        return $this->respondCreated($response);
    }
    public function updatediscount()
    {
        $db = db_connect();
            $refundAmount = $this->request->getVar("amount");
            $form_request_id = $this->request->getVar("form_request_id");
            $query = $db->query("SELECT Fr.data,Fr.form_type,Fr.user_id,Fr.batchid FROM form_requests Fr
                                 WHERE Fr.form_request_id = $form_request_id");
            $result = $query->getResultArray();
            $db->close();
            $data = json_decode($result[0]['data']);
             if($refundAmount != NULL || $refundAmount != ''){
                    if($result[0]['form_type']=="discountApproval")
                {
                    $data->Amount = $refundAmount;
                }else
                {
                    $data->RefundAmount = $refundAmount;
                }
                }
                $main['data'] = json_encode($data);

                $builder = $db->table('form_requests');
                $builder->where('form_request_id', $form_request_id);
                $builder->update($main);
                $response = [
            "status" => true,
            "message" => "success",
        ];
        return $this->respondCreated($response);
    }
    public function send()
	{
		$device_token = "e4yiqRZZLEg7jSyxxFT3t_:APA91bEzaEOEeN4u3noF4fEGupoL3S5VVTFHjDlVNPZ_H9GvL_yMsqpdUH8PxNQtdTwwgX5t59tXddook5a9eWO20NrEApu5Tnwl78jIwWgMCICed5gR7hjRUXFLxzYeRY0-tyzdB73e";
        $description = "S-voucher Requested have been approved";
                $message = "S-voucher";
                $google_api_key =
                    "AAAAVgjSTtk:APA91bHDVyLfnWLl4NzHOHA8oE8-vMdqUXSNs2Z016_ecAQKstmNj4aQztNcTY_WC6nj-zl0XkAux4OlTqMQDzKSlVkU5xpq0Ya-IpNC7LxiA95dzW9LIpg8YLK1G8JJ9Uhml-CzrAgr";
                $registrationIds = $device_token;
                #prep the bundle
                $msg = [
                    "body" => $description,
                    "title" => $message,
                    "sound" => 1 /*Default sound*/,
                ];

                $fields = [
                    "to" => $registrationIds,
                    "notification" => $msg,
                ];
                $headers = [
                    "Authorization: key=" . $google_api_key,
                    "Content-Type: application/json",
                ];
                #Send Reponse To FireBase Server
                $ch = curl_init();
                curl_setopt(
                    $ch,
                    CURLOPT_URL,
                    "https://fcm.googleapis.com/fcm/send"
                );
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
                $result = curl_exec($ch);
                curl_close($ch);
		
	}

	public function sendNotification($device_token, $message)
    {
        $SERVER_API_KEY = 'AAAAVgjSTtk:APA91bHDVyLfnWLl4NzHOHA8oE8-vMdqUXSNs2Z016_ecAQKstmNj4aQztNcTY_WC6nj-zl0XkAux4OlTqMQDzKSlVkU5xpq0Ya-IpNC7LxiA95dzW9LIpg8YLK1G8JJ9Uhml-CzrAgr';
  
        // payload data, it will vary according to requirement
        $data = [
            "to" => $device_token, // for single device id
            "data" => $message
        ];
        $dataString = json_encode($data);
    
        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];
    
        $ch = curl_init();
      
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
               
        $response = curl_exec($ch);
      
        curl_close($ch);
      
        return $response;
    }

    public function get_manufacturers()
    {
        $manufacturerModel = new ManufacturerModel();
        $data = $manufacturerModel->getManufacturers();

        return $this->respond([
            'status' => true,
            'message' => "Manufacturers successfully fetched",
            'data' => $data
        ]);
    }

    public function get_products()
    {
        $productModel = new InventoryModel();
        $data = $productModel->getproducts();

        return $this->respond([
            'status' => true,
            'message' => "Products successfully fetched",
            'data' => $data
        ]);
    }
}
