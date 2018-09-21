#ifndef TABLEMODEL_H
#define TABLEMODEL_H

#include <QComboBox>
#include <QTableWidget>

class TableModel : public QTableWidget
{
    Q_OBJECT
public:
    explicit TableModel(QWidget *parent = 0);

    void AddLine(QString name, QString type, QString max, QString key, QString nullable, bool edit = true, bool showList = true, bool getter = false, QString renderas = "string");
    QComboBox *getComboRenderAs(QString renderas);
    QString getEditFieldList();
    QString getPrimaryKey();
    QString getNullableFieldList();
    QString getListFieldList();
signals:

public slots:

public:
    static const int COLUMN_NAME = 0;
    static const int COLUMN_PRIMARY_KEY = 3;
    static const int COLUMN_NULLABLE_FIELD = 4;
    static const int COLUMN_SHOW_EDIT = 5;
    static const int COLUMN_SHOW_LIST = 6;



};

#endif // TABLEMODEL_H
