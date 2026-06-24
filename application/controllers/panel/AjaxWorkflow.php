<?php

class AjaxWorkflow extends PrivateController
{
    public function __construct()
    {
        parent::__construct();
        if(! $this->input->is_ajax_request())
        {
            redirect('404');
        }
		// $this->_validateFeature('workflow_index');
    }

    public function ajaxDtAll()
    {
        $additionalParameters = $this->input->post('additionalParameters') ?? [];
        $dt = new JqdtHandler($this->input->post());
        
        // ── Build query params for Serebo2's API ──────────────────────────────────
        $queryParams = [
            'per_page'   => $dt->getLength(),
            'page'       => $dt->getStart() > 0 ? (int) ($dt->getStart() / $dt->getLength()) + 1 : 1,
            'order_by'   => $dt->getOrderName(0) ?: 'entry_date_pro',
            'order_type' => $dt->getOrderDir(0) ?: 'desc',
        ];
        
        if ($dt->hasSearchValue())
        {
            $queryParams['search'] = $dt->getSearchValue();
        }
        
        // Map old handler filter keys -> Serebo2 API query param names
        $filterMap = PrivateController::serebo2ApiParamNames();
        
        foreach ($filterMap as $oldKey => $newKey)
        {
            if (isset($additionalParameters[$oldKey]) && $additionalParameters[$oldKey] !== '')
            {
                $queryParams[$newKey] = $additionalParameters[$oldKey];
            }
        }
        
        // ── Call Serebo2's API ──────────────────────────────────────────────────
        $response = WorkflowApiClient::getPaginated($queryParams);
        
        if ($response === null || !isset($response['data']))
        {
            // Same fallback as the old method: return an empty DataTables payload
            // instead of breaking the front-end if Serebo2 is unreachable.
            echo $dt->getJsonResponse(0, 0, []);
            exit;
        }
        
        $recordsTotal    = $response['meta']['total'] ?? 0;
        $recordsFiltered = $recordsTotal;
        $rows            = $response['data'];
        
        echo $dt->getJsonResponse($recordsTotal, $recordsFiltered, $rows);
        exit;
    }

    public function select2_old()
    {
        $term   = $this->input->post("term");
        $limit  = (int) $this->input->post("limit");
        $page   = (int) $this->input->post("page");
        $additionalParameters = $this->input->post('additionalParameters') ?? [];

        // Columns Select2 needs alongside "id" and "text" for each option.
        $columnsToShow = ['fiscal_responsible_id', 'fiscal_responsible', 'builder_responsible', 'builder_responsible_id', 'approved_reservation_number'];

        $queryParams = [
            'per_page'   => $limit,
            'page'       => $page,
            'order_by'   => 'code_pro',
            'order_type' => 'asc',
        ];

        if ($term !== null && $term !== '')
        {
            $queryParams['search'] = $term;
        }

        // Map old handler filter keys -> Serebo2 API query param names
        $filterMap = [
            'status'                             => 'status',
            'status-keyword'                     => 'keyword',
            'work-area'                          => 'work_area',
            'system'                             => 'system',
            'management-by'                      => 'management_by',
            'contract-id'                        => 'contract_id',
            'fiscal-responsible-id'              => 'fiscal_id',
            'builder-responsible-id'             => 'builder_id',
            'manpower-uploaded'                  => 'manpower_uploaded',
            'trim-tree'                          => 'trim_tree',
            'has-location'                       => 'has_location',
            'code-list'                          => 'code_list',
            'id-list'                            => 'id_list',
        ];

        foreach ($filterMap as $oldKey => $newKey)
        {
            if (isset($additionalParameters[$oldKey]) && $additionalParameters[$oldKey] !== '')
            {
                $queryParams[$newKey] = $additionalParameters[$oldKey];
            }
        }

        $response = WorkflowApiClient::getPaginated($queryParams);

        if ($response === null || !isset($response['data']))
        {
            // Same fallback shape Select2 expects on an empty/failed result.
            echo json_encode(['list' => [], 'pagination' => ['more' => false]]);
            exit;
        }

        $rows            = $response['data'];
        $recordsFiltered = $response['meta']['total'] ?? count($rows);

        $list = [];
        foreach ($rows as $row)
        {
            $option = [
                'id'   => $row['id_pro'],
                'text' => $row['code_pro'],
            ];

            foreach ($columnsToShow as $column)
            {
                $option[$column] = $row[$column] ?? null;
            }

            $list[] = $option;
        }

        $result = [
            'list'       => $list,
            'pagination' => ['more' => ($page * $limit) < $recordsFiltered],
        ];

        echo json_encode($result);
        exit;
    }

    public function infoForRequestAdditionalToCRE()
    {
        $projectId = (int) $this->input->post("projectId");
    
        $data = WorkflowApiClient::getOne($projectId);
    
        $response = [
            'data'    => $data ?? [],
            'success' => $data !== null ? 1 : 0,
            'message' => $data !== null ? '' : 'No se pudo obtener la información del proyecto.',
        ];
    
        echo json_encode($response);
        exit;
    }
}
