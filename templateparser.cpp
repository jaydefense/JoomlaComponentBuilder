#include "tabmodelwidget.h"
#include "templateparser.h"

#include <QDir>
#include <QFile>
#include <QMessageBox>
#include <QTextStream>
#include <qdebug>
#include <ui_mainwindow.h>
#include <QTabWidget>


TemplateParser::TemplateParser(MainWindow *mainWind, QString component)
{
    //ui=mainWind->ui;
    mainWindow = mainWind;
    componentName = component;
}

void TemplateParser::generateFile(QString filename,QString pathToResult,QString filenameResult)
{
    qDebug() << "generateFile" << filename << "->" << pathToResult<< filenameResult;
    if (pathToResult == NULL)
        pathToResult=".";

    // create directory
    QDir dir(pathToResult);
    if (!dir.exists()){
        QDir dir2(QDir::homePath());
        if (dir2.mkpath(pathToResult) == false)
            QMessageBox::information(0, "error", "can not create " + pathToResult );
            return;
    }

    // check file
    QFile fileIn(filename);
    if(!fileIn.open(QIODevice::ReadOnly))
    {
        QMessageBox::information(0, "error", filename + " not found - " + fileIn.errorString());
        return;
    }

    QFile fileOut(pathToResult+"/"+filenameResult);
    if (!fileOut.open(QFile::WriteOnly | QFile::Text))
    {
        QMessageBox::information(0, "Application",filenameResult + " not openable - " + fileOut.errorString() );
        return;
    }

    QTextStream in(&fileIn);
    QTextStream out(&fileOut);

    while(!in.atEnd()) {
        QString line = in.readLine();

        out << replaceOccurance(line) + "\n";
        //qDebug() << line << "\n";
        //QStringList fields = line.split(",");
        //model->appendRow(fields);
    }

    fileIn.close();
    fileOut.close();
}


void TemplateParser::generate(QString pathToResult)
{
    QString table;
    QString tableList;
    QString tablePrefix;
    tablePrefix = getValue("tableprefix");

    generateFile("template/install.xml",pathToResult,"install.xml");
    generateFile("template/index.html",pathToResult,"index.html");

    //Language
    TableTranslator *translate = mainWindow->findChild<TableTranslator*>("tableTranslation");
    QString strTranslate = translate->toStringLanguage();
    qDebug() << "Admin Controller - lang=" + getValue("language");
    writeFile(pathToResult+"/languages",getValue("language") +"." + componentName + ".ini" ,strTranslate);
    writeFile(pathToResult+"/admin/languages",getValue("language") +"." + componentName + ".ini" ,strTranslate);
    writeFile(pathToResult+"/admin/languages",getValue("language") +"." + componentName + "sys.ini" ,strTranslate);

    //Admin
    generateFile("template/admin/beAccess.xml",pathToResult+"/admin","access.xml");
    generateFile("template/admin/beControllerDefault.php",pathToResult+"/admin","controller.php");
    generateFile("template/admin/beEntryPoint.php",pathToResult+"/admin",componentName+".php");
    generateFile("template/index.html",pathToResult+"/admin","index.html");

    //Site
    generateFile("template/admin/beControllerDefault.php",pathToResult+"/site","controller.php");
    generateFile("template/admin/beEntryPoint.php",pathToResult+"/site",componentName+".php");
    generateFile("template/index.html",pathToResult+"/site","index.html");

    //Admin/sql
    QPlainTextEdit *txtInstall = mainWindow->findChild<QPlainTextEdit*>("fldSqlinstall");
    writeFile(pathToResult+"/admin","install.sql", txtInstall->toPlainText());
    QPlainTextEdit *txtUninstall = mainWindow->findChild<QPlainTextEdit*>("fldSqluninstall");
    writeFile(pathToResult+"/admin","uninstall.sql", txtUninstall->toPlainText());

    qDebug() << "Admin Controller";
    //QTabWidget *tabWidget = ui->tabModel;
    QTabWidget *tabWidget = mainWindow->findChild<QTabWidget*>("tabModel");
    qDebug() << "tab count=" + tabWidget->count();
    for (int index=0; index < tabWidget->count(); index++)
    {
        table=tabWidget->tabText(index).replace(tablePrefix,"");
        tableList=table+"list";
        qDebug() << "index: "+ index << " - " <<tableList;

        TabModelWidget *tabModelWidget =(TabModelWidget*) tabWidget->widget(index);
        TableModel *tableModel =  tabModelWidget->getTable();

        mapVariable.insert("nameobject", table);
        mapVariable.insert("nameobjectlist", tableList);
        mapVariable.insert("table", table);
        mapVariable.insert("fieldlist", tableModel->getEditFieldList());
        mapVariable.insert("primarykey", tableModel->getPrimaryKey());
        mapVariable.insert("nullablefieldlist", tableModel->getNullableFieldList());
        mapVariable.insert("fieldSearchList", tableModel->getListFieldList());
        // Admin
        if (tabModelWidget->isAdmin())
        {
            //Admin controller
            if (tabModelWidget->isEdit())
            {
                generateFile("template/admin/controllers/beController.php",pathToResult+"/admin/controllers",table+".php");
            }
            if (tabModelWidget->isList())
            {
                generateFile("template/admin/controllers/beControllerList.php",pathToResult+"/admin/controllers",tableList+".php");
            }
            //Admin model
            if (tabModelWidget->isEdit())
            {
                generateFile("template/admin/models/beModel.php",pathToResult+"/admin/models",table+".php");
            }
            if (tabModelWidget->isList())
            {
                generateFile("template/admin/models/beModelList.php",pathToResult+"/admin/models",tableList+".php");
            }

            //Admin model Form
            generateFile("template/admin/models/forms/beForm.js",pathToResult+"/admin/models/forms",table+".js");
            generateFile("template/admin/models/forms/beForm.xml",pathToResult+"/admin/models/forms",table+".xml");

            // Table
            generateFile("template/admin/tables/beTable.php",pathToResult+"/admin/tables",table+".php");

            // View Edit
            if (tabModelWidget->isEdit())
            {
                generateFile("template/admin/views/beView/beView.php",pathToResult+"/admin/views/"+table,"view.html.php");
                generateFile("template/admin/views/beView/tmpl/beTmpl.php",pathToResult+"/admin/views/"+table+"/tmpl","edit.php");
            }
            if (tabModelWidget->isList())
            {
                generateFile("template/admin/views/beViewList/beViewList.php",pathToResult+"/admin/views/"+tableList,"view.html.php");
                generateFile("template/admin/views/beViewList/tmpl/beTmplList.php",pathToResult+"/admin/views/"+tableList+"/tmpl","default.php");
            }
        }

        // site
        if (tabModelWidget->isSite())
        {
            //site controller
            if (tabModelWidget->isEdit())
            {
                generateFile("template/admin/controllers/beController.php",pathToResult+"/site/controllers",table+".php");
            }
            if (tabModelWidget->isList())
            {
                generateFile("template/admin/controllers/beControllerList.php",pathToResult+"/site/controllers",table+"list.php");
            }

            //site model
            if (tabModelWidget->isEdit())
            {
                generateFile("template/admin/models/beModel.php",pathToResult+"/site/models",table+".php");
            }
            if (tabModelWidget->isList())
            {
                generateFile("template/admin/models/beModelList.php",pathToResult+"/site/models",table+"list.php");
            }

            //site model Form

            generateFile("template/admin/models/forms/beForm.js",pathToResult+"/site/models/forms",table+".js");
            generateFile("template/admin/models/forms/beForm.xml",pathToResult+"/site/models/forms",table+".xml");
        }
    }
}

QString TemplateParser::replaceOccurance(QString str)
{
    if (str== NULL)
        return "";

    QRegExp rx("(![A-Za-z0-9]+!)"); //(^![A-Za-z0-9]+!$) <name>com_!name!</name> !test!
    rx.setMinimal(true);

    int pos = 0;

    while ((pos = rx.indexIn(str)) != -1) {
        str.replace(rx.cap(1),getValue(rx.cap(1).replace("!","")));
    }

    return str;
}

QString TemplateParser::getValue(QString field)
{
    QString fld;
    QString value=NULL;
    QLineEdit *object;
    QComboBox *combo;
    if (field == NULL)
        return "";

    fld = "fld" + field.mid(0,1).toUpper()+ field.mid(1).toLower();
    qDebug() << "field: "+ field << "fld= " + fld;
    if((object = mainWindow->findChild<QLineEdit*>(fld)) != NULL)
    {
        value = object->text();
    }
    else if ( (combo = mainWindow->findChild<QComboBox*>(fld)) !=NULL )
    {
      value = combo->currentText();
    }
    else
    {
        qDebug() << "*** mapVariable ****" + field;
        // case sensitive
        value = mapVariable.value(field,NULL);
        if (value == NULL)
        {
            //case unsensitive
            value = mapVariable.value(field.toLower(),NULL);
        }
        qDebug() << "*** mapVariable value=" + value;
    }

    if (value != NULL)
    {
        //qDebug() << "field: " << fld << "=" + object->text();
        // Majuscule
        if (field.toUpper() == field)
            value = value.toUpper();
        else
        //Capitalization
        if (field.mid(0,1).toUpper() == field.mid(0,1))
            value = value.mid(0,1).toUpper()+ value.mid(1);

        return value;
    }

    return "*VAR_NOT_FOUND_"+ field + "_*";
}
void TemplateParser::setValue(QString field,QString value)
{
    QString fld;
    fld = "fld" + field.mid(0,1).toUpper()+ field.mid(1);
    QLineEdit *object = mainWindow->findChild<QLineEdit*>(fld);
    if(object == NULL)
    {
        qDebug() << "not found field: " << fld;
        return;
    }

    object->setText(value);
}


void TemplateParser::writeFile(QString pathToResult,QString filenameResult, QString content)
{
    qDebug() << "generateFile" << pathToResult<< filenameResult;

    if (pathToResult == NULL)
        pathToResult=".";

    // create directory
    QDir dir(pathToResult);
    if (!dir.exists()){
        QDir dir2(QDir::homePath());
        if (dir2.mkpath(pathToResult) == false)
            QMessageBox::information(0, "error", "can not create " + pathToResult );
            return;
    }

    QFile fileOut(pathToResult+"/"+filenameResult);
    if (!fileOut.open(QFile::WriteOnly | QFile::Text))
    {
        QMessageBox::information(0, "Application",filenameResult + " not openable - " + fileOut.errorString() );
        return;
    }

    QTextStream out(&fileOut);
    out << content + "\n";

    fileOut.close();
}







