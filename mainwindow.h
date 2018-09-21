#ifndef MAINWINDOW_H
#define MAINWINDOW_H

#include "dbtools.h"
#include "tabletranslator.h"

#include <QMainWindow>

namespace Ui {
class MainWindow;
}

class MainWindow : public QMainWindow
{
    Q_OBJECT

public:
    explicit MainWindow(QWidget *parent = 0);
    ~MainWindow();

public slots:
    void closeTabModel(int index);
private slots:
    void on_btnGenerate_clicked();
    void on_btnAddModel_clicked();
    void on_btnAddView_clicked();
    void on_regExp_clicked();
    void on_actionSave_triggered();
    void on_actionSave_as_triggered();
    void on_actionNew_triggered();
    //void on_btnAddView_clicked();

private:
    Ui::MainWindow *ui;
    DbTools *dbtools;
    TableTranslator *tableTranslator;
    QString filename=NULL;
};

#endif // MAINWINDOW_H
