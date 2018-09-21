#include "tabmodelwidget.h"
#include "ui_tabmodelwidget.h"

TabModelWidget::TabModelWidget(QWidget *parent) :
    QWidget(parent),
    ui(new Ui::TabModelWidget)
{
    ui->setupUi(this);
}

TabModelWidget::~TabModelWidget()
{
    delete ui;
}


TabModelWidget::TabModelWidget(QWidget *parent,QString name ) :QWidget(parent),
    ui(new Ui::TabModelWidget)
{
    ui->setupUi(this);

    this->setObjectName(name);

}

TableModel  *TabModelWidget::getTable()
{
    return ui->table;
}

bool TabModelWidget::isSite()
{
    return ui->checkSite->isChecked();
}

bool TabModelWidget::isAdmin()
{
    return ui->checkAdmin->isChecked();
}

bool TabModelWidget::isList()
{
    return ui->checkList->isChecked();
}

bool TabModelWidget::isEdit()
{
    return ui->checkList->isChecked();
}

bool TabModelWidget::isSimple()
{
    return ui->checkSimple->isChecked();
}
