#include "dbtools.h"
#include "tabmodelwidget.h"
#include <QLayout>
#include <QPlainTextEdit>
#include <QWidget>
#include <qdebug>
#include <qtabwidget.h>

DbTools::DbTools(QTabWidget *tabModel, TableTranslator *tableTranslator,QPlainTextEdit *txtInstall, QPlainTextEdit *txtUninstall)
{
    this->tableTranslator = tableTranslator;
    this->txtInstall=txtInstall;
    this->txtUninstall=txtUninstall;
    this->tabModel=tabModel;
}

bool DbTools::connect()
{
       bdd = QSqlDatabase::addDatabase("QMYSQL");
       bdd.setHostName("localhost");
       bdd.setDatabaseName("lmnp_impots");
       bdd.setUserName("jerome");
       bdd.setPassword("jerome");
       bdd.setPort(3306);
       qDebug() << "BDD: " << bdd.open();
       return bdd.open();
}

QString DbTools::showTablesInTabs(QString prefix)
{
    QSqlQuery query;
    QString request;
    request = "select TABLE_NAME from information_schema.tables ";
    if (prefix != NULL)
    {
        request = request + "where table_name like '" + prefix + "%'";
    }
    query.exec(request);
    while (query.next())
    {
       // addNewTable(query.value(0).toString());
        addNewTab(query.value(0).toString());
    }

    makeScriptSqlInstall();
    return "OK";
}

void DbTools::addNewTab(QString name )
{
    TabModelWidget *tabWidget = new TabModelWidget(NULL,name);
    tabModel->addTab(tabWidget, name);
    populateFieldsTable(name,tabWidget->getTable());
}

void DbTools::populateFieldsTable(QString tableName, TableModel *tableModel)
{
    QString name;
    QString type;
    QString max;
    QString key;
    QString nullable;
    QSqlQuery query;
    QString request;

    request = "SELECT COLUMN_NAME,DATA_TYPE,CHARACTER_MAXIMUM_LENGTH,IS_NULLABLE,COLUMN_KEY FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA='LMNP_IMPOTS' AND TABLE_NAME='"+ tableName + "'" + "ORDER BY ORDINAL_POSITION";
    query.exec(request);


    while (query.next())
    {
            name = query.value("COLUMN_NAME").toString();
            type = query.value("DATA_TYPE").toString();
            max = query.value("CHARACTER_MAXIMUM_LENGTH").toString();
            key = query.value("COLUMN_KEY").toString();
            nullable = query.value("IS_NULLABLE").toString();

            qDebug() << name;


            tableModel->AddLine(name,type,max,key,nullable);
            tableTranslator->AddLine(tableName,name,"LABEL", name.replace("_"," "));
    }
}

void DbTools::makeScriptSqlInstall()
{
    QString install;
    QString uninstall;
    QSqlQuery query;
    QString request;

    request = "show create table ";

    for (int index=0; index < tabModel->count(); index++)
    {
        query.exec(request + tabModel->tabText(index));
        if (query.next())
        {
                install = install + query.value(1).toString() + ";\n\n";
                uninstall = uninstall + "DROP TABLE " + tabModel->tabText(index) + ";\n";
        }
    }
    txtInstall->setPlainText(install);
    txtUninstall->setPlainText(uninstall);
}
