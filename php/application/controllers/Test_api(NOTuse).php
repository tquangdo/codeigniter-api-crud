<?php
defined('BASEPATH') OR exit('No direct script access allowed');
define("API_URL", "http://192.168.0.15:8000/index.php/api"); //KO được localhost hay 127.0.0.1

class Test_api extends CI_Controller {
    function index()
    {
        $this->load->view('api_view');
    }

    function onActionCRUD()
    {
        if($this->input->post('data_action_fromv'))
        {
            $data_action_fromv = $this->input->post('data_action_fromv');
            // DEL
           if($data_action_fromv == "DeleteFromV")
           {
                $api_url = API_URL."/onDelete";
                $form_data = array(
                    'id_from_test'  => $this->input->post('user_id_fromv')
                );
                $client = curl_init($api_url);
                curl_setopt($client, CURLOPT_POST, true);
                curl_setopt($client, CURLOPT_POSTFIELDS, $form_data);
                curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($client);
                if ($response === false)
                {  
                    print_r('DEL error: ' . curl_error($ch));
                    die;
                }
                curl_close($client);
                echo $response;
           }

            // UPD
           if($data_action_fromv == "EditFromV")
           {
                $api_url = API_URL."/onUpdate";
                $form_data = array(
                    'first_name_from_test'  => $this->input->post('first_name_fromv'),
                    'last_name_from_test'   => $this->input->post('last_name_fromv'),
                    'id_from_test'          => $this->input->post('user_id_fromv')
                );
                $client = curl_init($api_url);
                curl_setopt($client, CURLOPT_POST, true);
                curl_setopt($client, CURLOPT_POSTFIELDS, $form_data);
                curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($client);
                if ($response === false)
                {  
                    print_r('UPD error: ' . curl_error($ch));
                    die;
                }
                curl_close($client);
                echo $response;
           }

            // UPD-SEL
           if($data_action_fromv == "FetchSingleFromV")
           {
                $api_url = API_URL."/onFetchSingle";
                $form_data = array(
                    'id_from_test'  => $this->input->post('user_id_fromv')
                );
                $client = curl_init($api_url);
                curl_setopt($client, CURLOPT_POST, true); // phải đúng thứ tự dòng này đầu tiên!!!
                curl_setopt($client, CURLOPT_POSTFIELDS, $form_data);
                curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($client);
                if ($response === false)
                {  
                    print_r('UPD-SEL error: ' . curl_error($ch));
                    die;
                }
                curl_close($client);
                echo $response;
           }

           // bị bể format bootstrap + DLG KO thể chạy đúng!!! 
           // echo '<script> console.log("data_action_fromv: '. $data_action_fromv. '");</script>';
           // echo '<script> alert("~~~~~~~~~~~~~'. $data_action_fromv. '~~~~~~~~~~~~~");</script>';
           // INS
           if($data_action_fromv == "InsertFromV")
           {
                $api_url = API_URL."/onInsert";
                $form_data = array(
                    'first_name_from_test'  => $this->input->post('first_name_fromv'),
                    'last_name_from_test'   => $this->input->post('last_name_fromv')
                );
                $client = curl_init($api_url);
                curl_setopt($client, CURLOPT_POST, true);
                curl_setopt($client, CURLOPT_POSTFIELDS, $form_data);
                curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($client);
                if ($response === false)
                {  
                    print_r('INS error: ' . curl_error($ch));
                    die;
                }
                curl_close($client);
                echo $response;
           }

            // SEL
            if($data_action_fromv == "FetchAllFromV")
            {
                $ch = curl_init();
                if ($ch !== false)
                {
                    $target_url = API_URL;
                    curl_setopt($ch, CURLOPT_URL,$target_url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
                    $response = curl_exec($ch);
                    if ($response === false)
                    {  
                        print_r('SEL error: ' . curl_error($ch));
                        die;
                    }
                    curl_close($ch);
                    $result = json_decode($response); //JSON string -> PHP array
                }
                else
                {
                    echo '<script> alert("LỖI!!!!!");</script>';
                }
                $output = '';
                if(count($result) > 0)
                {
                    foreach($result as $row_item)
                    {
                        // $row_item-> map với table's column name
                        $output .= '
                            <tr>
                                <td>'.$row_item->first_name.'</td>
                                <td>'.$row_item->last_name.'</td>
                                <td>
                                    <button type="button" class="btn btn-warning btn-xs edit" id="'.$row_item->id.'">
                                        Edit
                                    </button>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-xs delete" id="'.$row_item->id.'" value="'.$row_item->first_name.'">
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        ';
                    }
                }
                else
                {
                    $output .= '
                        <tr>
                            <td colspan="4" align="center">No Data Found</td>
                        </tr>
                    ';
                }
                echo $output; //trả HTML data về cho Ajax req của api_view.php
            }
        }
    }
}

?>