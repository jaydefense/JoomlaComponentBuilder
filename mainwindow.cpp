#include "config.h"
#include "dbtools.h"
#include "mainwindow.h"
#include "tabletranslator.h"
#include "tabmodelwidget.h"
#include "templateparser.h"
#include "ui_mainwindow.h"
#include <qdebug>
#include <QDate>
#include <QFileDialog>
#include <QMessageBox>

MainWindow::MainWindow(QWidget *parent) :
    QMainWindow(parent),
    ui(new Ui::MainWindow)
{
    ui->setupUi(this);
    ui->fldLanguage->addItem("fr-FR");
    ui->fldLanguage->addItem("en-EN");

    ui->fldDbType->addItem("QMYSQL");
    ui->fldDbType->addItem("QORACLE");

    connect(ui->tabModel, SIGNAL(tabCloseRequested(int)), this, SLOT(closeTabModel(int)));
    //QDate date ;

    QString dateTimeString = QDate::currentDate().toString("yyyy-MM-dd");
    ui->fldDate->setText(dateTimeString);



    DbTools *dbtools = new DbTools(ui->tabModel, ui->tableTranslation, ui->fldSqlinstall,ui->fldSqluninstall);
    dbtools->connect();
    dbtools->showTablesInTabs("lmnp");


}

MainWindow::~MainWindow()
{
    delete ui;
}


void MainWindow::on_btnGenerate_clicked()
{
    TemplateParser *parser = new TemplateParser(this,"lmnp");
    parser->generate(ui->fldPath->text());
}

void MainWindow::on_regExp_clicked()
{
    QString str, reg;
    str = ui->textLineEdit->text();
    reg = ui->fldRegularExp->text();

    QRegExp rx("(!.*!)");
    if (reg != "")
        rx.setPattern(reg);
    rx.setMinimal(true);
    QStringList list;
    int pos = 0;

    while ((pos = rx.indexIn(str)) != -1) {
         ui->resultLineEdit->setText( ui->resultLineEdit->text() + rx.cap(1) + QString::number(pos) + "_" + QString::number(rx.matchedLength()) + " ---");
         str.replace(rx.cap(1),"VAL");
         ui->textLineEdit->setText(str);
        pos += rx.matchedLength();
    }


}


void MainWindow::on_btnAddView_clicked()
{
    QString name = "view" + ui->tabView->count();
    QWidget *widgetContener = new QWidget();
    widgetContener->setObjectName(name);
    QVBoxLayout *tableLayout = new QVBoxLayout();
    widgetContener->setLayout(tableLayout);
    widgetContener->setSizePolicy(QSizePolicy ::Expanding , QSizePolicy ::Expanding );
    ui->tabView->addTab(widgetContener, name);
}


void MainWindow::on_btnAddModel_clicked()
{
    TabModelWidget *tabWidget = new TabModelWidget(NULL,ui->fldNewtable->text());
    ui->tabModel->addTab(tabWidget, ui->fldNewtable->text());
}

void MainWindow::closeTabModel(int index)
{
    ui->tabModel->removeTab(index);
}

void MainWindow::on_actionSave_triggered()
{
    if (filename == NULL)
        return on_actionSave_as_triggered();

    QFile fileOut(filename);
    if (!fileOut.open(QFile::WriteOnly | QFile::Text))
    {
        QMessageBox::information(0, "Application",filename + " not writable - " + fileOut.errorString() );
        return;
    }

    QTextStream out(&fileOut);


    QString name;
    for (int index=0; index < ui->tabComponant->count(); index++)
    {
        QWidget *widget = ui->tabComponant->widget(index);
        name = widget->objectName();
        out << "//" + name + "\n";
        qDebug() << name;
        if (name == "dbTables")
        {

        }
        else
        {
            QList<QLineEdit*> list = widget->findChildren<QLineEdit*>();
            foreach(QLineEdit *line, list) {
               out << line->objectName() + "=" + line->text() + "\n";
               qDebug() << ""+ line->objectName() + "=" + line->text();
            }
            QList<QComboBox*> list2 = widget->findChildren<QComboBox*>();
            foreach(QComboBox *line, list2) {
               out << line->objectName() + "=" + line->currentText() + "\n";
               qDebug() << ""+ line->objectName() + "=" + line->currentText();
            }
            QList<QPlainTextEdit*> list3 = widget->findChildren<QPlainTextEdit*>();
            foreach(QPlainTextEdit *line, list3) {
               out << line->objectName() + "=" + line->toPlainText() + "\n";
               qDebug() << ""+ line->objectName() + "=" + line->toPlainText();
            }
        }
    }


    fileOut.close();
}
void MainWindow::on_actionSave_as_triggered()
{
    filename = QFileDialog::getSaveFileName(this, tr("Save as..."),
                                                     QString(), tr("properties (*.properties);;All Files (*)"));
    if (filename.isEmpty())
           return;

    if (! (filename.endsWith(".properties", Qt::CaseInsensitive)) )
           filename += ".properties"; // default

    on_actionSave_triggered();
    return;
}

void MainWindow::on_actionNew_triggered()
{

}
