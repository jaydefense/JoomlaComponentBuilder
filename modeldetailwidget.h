#ifndef MODELDETAILWIDGET_H
#define MODELDETAILWIDGET_H

#include <QWidget>

namespace Ui {
class ModelDetailWidget;
}

class ModelDetailWidget : public QWidget
{
    Q_OBJECT

public:
    explicit ModelDetailWidget(QWidget *parent = 0);
    ~ModelDetailWidget();

private:
    Ui::ModelDetailWidget *ui;
};

#endif // MODELDETAILWIDGET_H
