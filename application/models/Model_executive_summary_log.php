<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 08/04/2019
 * Time: 10:50 AM
 */

class Model_executive_summary_log extends Model_executive_summary_log_base
{
    public function __construct($stage = "", $projectsQuantity = 0, $projectsPercentage = 0, $approvedBudget = 0, $approvedBudgetPercentage = 0, $contractPercentage = 0, $date = NULL)
    {
        parent::__construct($stage, $projectsQuantity, $projectsPercentage, $approvedBudget, $approvedBudgetPercentage, $contractPercentage, $date);
    }

    public static function saveLog($executiveSummaryReport = array())
    {
        $sectionIds = array(
          "design" => 1,
          "alreadySent" => 2,
          "inProgress" => 3,
          "closure" => 4,
          "closed" => 5
        );
        $toInsert = array();
        $list = $executiveSummaryReport["list"];
        $date = date("Y-m-d H:i:s");
        foreach ($list as $row)
        {
            $toInsert[] = array(
                "stage_esl" => $sectionIds[$row["section"]],
                "projects_quantity_esl" => $row["totalProjectsBySection"],
                "project_percentage_esl" => $row["totalPercentageProjectsBySection"],
                "approved_budget_esl" => str_replace(",","",$row["totalApprovedBudgetBySection"]),
                "approved_budget_percentage_esl" => $row["totalPercentageApprovedBudgetBySection"],
                "contract_percentage_esl" => $row["contractAmountPercentageBySection"],
                "date_esl" => $date,
            );
        }
        if(count($toInsert) > 0)
        {
            Model_executive_summary_log::insertBatch($toInsert);
        }
    }

    public static function getExecutiveSummaryLog($date = "")
    {
        $ci = &get_instance();
        $ci->load->database();

        $sql = "
            select ".static::TABLE_NAME.".* 
            from ".static::TABLE_NAME."
            where
            DATE_FORMAT(date_esl, '%Y-%m-%d') = ".$ci->db->escape($date)."
            and deleted_esl != 1
        ";
//        echo"<pre>";var_dump($sql);exit;
        $query = $ci->db->query($sql);
        $result = static::recastArray(get_called_class(), $query->result());
        return $result;
    }

    public static function getExecutiveSummaryDifferential($initialDate, $finalDate)
    {
        $ci = &get_instance();
        $ci->load->database();

        $sql = "
        SELECT
            final.*,
            final.projects_quantity_esl - initial.projects_quantity_esl diff_projects_quantity_esl,
            final.project_percentage_esl - initial.project_percentage_esl diff_project_percentage_esl,
            final.approved_budget_esl - initial.approved_budget_esl diff_approved_budget_esl,
            final.approved_budget_percentage_esl - initial.approved_budget_percentage_esl diff_approved_budget_percentage_esl,
            final.contract_percentage_esl - initial.contract_percentage_esl diff_contract_percentage_esl
        FROM
        sec_executive_summary_log initial
        LEFT JOIN sec_executive_summary_log final on initial.stage_esl = final.stage_esl and DATE_FORMAT(final.date_esl, '%Y-%m-%d') = ".$ci->db->escape($finalDate)." and final.deleted_esl != 1
        WHERE 
        DATE_FORMAT(initial.date_esl, '%Y-%m-%d') = ".$ci->db->escape($initialDate)."
        and initial.deleted_esl != 1
        ";
        $query = $ci->db->query($sql);
        $result = $query->result_array();
        return $result;
    }
}