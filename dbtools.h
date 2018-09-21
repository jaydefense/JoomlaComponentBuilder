#ifndef DBTOOLS_H
#define DBTOOLS_H

#include "tablemodel.h"
#include "tabletranslator.h"

#include <QtSql/QSql>
#include <QtSql/QSqlDatabase>
#include <QtSql/QSqlDriver>
#include <QtSql/QSqlQuery>

#include <QPlainTextEdit>
#include <QVBoxLayout>

class DbTools
{
public:
    DbTools(QTabWidget *tabModel, TableTranslator *tableTranslator, QPlainTextEdit *txtInstall, QPlainTextEdit *txtUninstall);

    QSqlDatabase bdd;
    TableTranslator *tableTranslator;
    QPlainTextEdit *txtInstall;
    QPlainTextEdit *txtUninstall;
    QTabWidget *tabModel;

    bool connect();

    QString showTablesInTabs(QString prefix);
    void populateFieldsTable(QString tableName, TableModel *tableModel);
    void addNewTable(QString name);
    void makeScriptSqlInstall();
    void addNewTab(QString name);
};

#endif // DBTOOLS_H
