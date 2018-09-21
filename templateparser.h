#include "mainwindow.h"

#include <QString>

#ifndef TEMPLATEPARSER_H
#define TEMPLATEPARSER_H

class TemplateParser
{
public:
    void generateFile(QString filename, QString pathToResult, QString filenameResult);
    void generate(QString pathToResult);


    QString replaceOccurance(QString str);
    QString getValue(QString field);
    TemplateParser(MainWindow *mainWind,QString component);
    void setValue(QString field, QString value);


    void writeFile(QString pathToResult, QString filenameResult, QString content);

private:
    Ui::MainWindow *ui;
    MainWindow *mainWindow;
    QString componentName;
    QMap<QString, QString> mapVariable;
};

#endif // TEMPLATEPARSER_H
