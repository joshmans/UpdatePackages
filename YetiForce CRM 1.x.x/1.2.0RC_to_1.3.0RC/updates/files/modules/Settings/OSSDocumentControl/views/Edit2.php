<?php
/*+***********************************************************************************************************************************
 * The contents of this file are subject to the YetiForce Public License Version 1.1 (the "License"); you may not use this file except
 * in compliance with the License.
 * Software distributed under the License is distributed on an "AS IS" basis, WITHOUT WARRANTY OF ANY KIND, either express or implied.
 * See the License for the specific language governing rights and limitations under the License.
 * The Original Code is YetiForce.
 * The Initial Developer of the Original Code is YetiForce. Portions created by YetiForce are Copyright (C) www.yetiforce.com. 
 * All Rights Reserved.
 *************************************************************************************************************************************/
Class Settings_OSSDocumentControl_Edit2_View extends Settings_OSSDocumentControl_Base_View {

    public function preProcess(Vtiger_Request $request) {
        parent::preProcess($request);
    }
    
    public function process(Vtiger_Request $request) {
        $moduleSettingsName = $request->getModule(false);
        $moduleName = $request->getModule();
        $baseModule = $request->get('module_name');
        $idTpl = $request->get('tpl_id');
        
        $viewer = $this->getViewer($request);

        if ($idTpl) {
            $docInfo = Settings_OSSDocumentControl_Module_Model::getDocInfo($idTpl); 
            $viewer->assign('BASE_INFO', $docInfo['basic_info']);
            //var_dump($docInfo['required_conditions']);
            for ($i = 0; $i < count($docInfo['required_conditions']); $i++) {
                $fieldModel = Vtiger_Field_Model::getInstance($docInfo['required_conditions'][$i]['fieldname'], Vtiger_Module_Model::getInstance($baseModule));
                $docInfo['required_conditions'][$i]['info'] = $fieldModel->getFieldInfo();
            }
            
            $viewer->assign('REQUIRED_CONDITIONS', $docInfo['required_conditions']);
                 
            for ($i = 0; $i < count($docInfo['optional_conditions']); $i++) {

                $fieldModel = Vtiger_Field_Model::getInstance($docInfo['optional_conditions'][$i]['fieldname'], Vtiger_Module_Model::getInstance($baseModule));
                $docInfo['optional_conditions'][$i]['info'] = $fieldModel->getFieldInfo();
            }
            $viewer->assign('OPTIONAL_CONDITIONS', $docInfo['optional_conditions']);
            $viewer->assign('TPL_ID', $idTpl);
            
            //$fieldModel = Vtiger_Field_Model::getInstance($value->get('name'), $baseModuleModel);
        }
        
        $viewer->assign('MODULE_NAME', $moduleName);
        $viewer->assign('SUMMARY', $request->get('summary'));
        $viewer->assign('BASE_MODULE', $baseModule);
        $viewer->assign('QUALIFIED_MODULE', $moduleSettingsName);
        $viewer->assign('FIELD_LIST', Settings_OSSDocumentControl_Module_Model::getListBaseModuleField($baseModule));
        //$viewer->assign('FOLDER_LIST', Documents_Module_Model::getAllFolders());
        $viewer->assign('CONDITION_BY_TYPE', Settings_OSSDocumentControl_Module_Model::getConditionByType());

        echo $viewer->view('Edit2.tpl', $moduleSettingsName, true);
    }

}
