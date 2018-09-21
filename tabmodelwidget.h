#ifndef TABMODELWIDGET_H
#define TABMODELWIDGET_H

#include "tablemodel.h"

#include <QWidget>

namespace Ui {
class TabModelWidget;
}

class TabModelWidget : public QWidget
{
    Q_OBJECT

public:
    explicit TabModelWidget(QWidget *parent = 0);
    TabModelWidget(QWidget *parent, QString name);
    ~TabModelWidget();

    static TableModel *addNewTab(QString name);
    TableModel *getTable();

    bool isAdmin();
    bool isSite();
    bool isList();
    bool isEdit();
    bool isSimple();
private:
    Ui::TabModelWidget *ui;
};

#endif // TABMODELWIDGET_H
