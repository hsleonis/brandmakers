<?php

namespace backend\controllers;

use Yii;
use backend\models\ProductSpecification;
use backend\models\ProductSpecificationSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProductspecificationController implements the CRUD actions for ProductSpecification model.
 */
class ProductspecificationController extends Controller
{
    
    public function beforeAction($action){
        if(Yii::$app->params['setup.status']!="Installed"){
            return $this->redirect(['/setup/index']);
        }
        
        $this->getView()->theme = Yii::createObject([
            'class' => '\yii\base\Theme',
            'pathMap' => ['@app/views' => '@app/web/themes/'.Yii::$app->params['backend.theme']],
            'baseUrl' => '@web/themes/'.Yii::$app->params['backend.theme'],
        ]);

        return parent::beforeAction($action);
    }


    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }



   /* public function actionTabular_input()
    {
        $model = new ProductCategory();
        $query = ProductCategory::find()->indexBy('id'); // where `id` is your primary key
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pagesize' => 5
            ]
        ]);
        $models = $dataProvider->getModels();

        
        if (Yii::$app->request->isAjax) {
            if (isset($_POST['ProductCategory']) && isset($_POST['ProductCategory']['cat_create']) ) {
                $model = new ProductCategory();
                $model->attributes = $_POST['ProductCategory'];
            
                if($model->save()){

                    $response['files'] = ['ok'];
                    $response['result'] = 'success';

                    $model_uu = new ProductCategory();
                    $query = ProductCategory::find()->indexBy('id'); // where `id` is your primary key
                    $dataProvider = new ActiveDataProvider([
                        'query' => $query,
                        'pagination' => [
                            'pagesize' => 5
                        ]
                    ]);
                    $models = $dataProvider->getModels();
                    $response['post_list'] = $this->renderAjax('ajax_cont', ['dataProvider'=>$dataProvider,'model'=>$model_uu]);
                    return json_encode($response);
                }else{
                    $response['result'] = 'error';
                    $response['files'] =  Html::errorSummary($model);
                    return json_encode($response);
                }
            }
            else if (ProductCategory::loadMultiple($models, Yii::$app->request->post()) && ProductCategory::validateMultiple($models)) {
                $count = 0;
                foreach ($models as $index => $model) {
                    // populate and save records for each model
                    if ($model->save()) {
                        $count++;
                    }
                }
                Yii::$app->session->setFlash('success', "Processed {$count} records successfully.");
                $response['files'] = "Processed {$count} records successfully.";
                $response['result'] = 'success';

                return json_encode($response);
            } 
        }

        

        return $this->render('tabular_input',['dataProvider'=>$dataProvider,'model'=>$model]);

    }*/










    


    public function actionCreate()
    {
        $model = new ProductSpecification();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }


    protected function findModel($id)
    {
        if (($model = ProductSpecification::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
