#include "tablemodel.h"

#include <QCheckBox>
#include <QHeaderView>
#include <qdebug>
TableModel::TableModel(QWidget *parent) :
    QTableWidget(parent)
{
    QString str=tr("Name,Field type,Max,Key,Nullable,Show edit,Show List,Requiered,Get field,Render as,Validator client,Validator server");
    QStringList labels = str.split(",");
    setColumnCount(labels.size());
    setHorizontalHeaderLabels(labels);
}

void TableModel::AddLine(QString name,QString type,QString max, QString key, QString nullable, bool edit, bool showList, bool getter, QString renderas  )
{

    int row=0,col=0;
    QCheckBox  *check;
    QTableWidgetItem *item;

    row = rowCount();
    insertRow(row);

    item = new QTableWidgetItem(name);
    setItem(row,col++,item);

    item = new QTableWidgetItem(type);
    setItem(row,col++,item);

    item = new QTableWidgetItem(max);
    setItem(row,col++,item);

    item = new QTableWidgetItem(key);
    setItem(row,col++,item);

    item = new QTableWidgetItem(nullable);
    setItem(row,col++,item);


    check = new QCheckBox();
    check->setChecked(edit);
    setCellWidget(row,col++,check);

    check = new QCheckBox();
    check->setChecked(showList);
    setCellWidget(row,col++,check);

    check = new QCheckBox();
    check->setChecked(getter);
    setCellWidget(row,col++,check);

    check = new QCheckBox();
    check->setChecked(getter);
    setCellWidget(row,col++,check);

    if (key == "PRI")
        renderas="hidden";
    else if (type.indexOf("date") >=0)
        renderas="calendar";
    else if (name.toLower().indexOf("password") >=0)
        renderas="password";
    else if (type.indexOf("int") >=0)
        renderas="numeric";
    else if (type.indexOf("decimal") >=0)
        renderas="numeric";
    else if (type.indexOf("float") >=0)
        renderas="numeric";
    setCellWidget(row,col++,getComboRenderAs(renderas));
}

QComboBox *TableModel::getComboRenderAs(QString renderas)
{
    QComboBox *combo = new QComboBox();
    combo->addItem("string");
    combo->addItem("calendar");
    combo->addItem("combo");
    combo->addItem("numeric");
    combo->addItem("hidden");
    combo->addItem("password");

    if (renderas != "")
        combo->setCurrentText(renderas);


    return combo;
}

QString TableModel::getEditFieldList()
{
    QString result="";
    int row;

    for (row=0;row < this->rowCount(); row++)
    {
        qDebug() << "row " <<  item(row,COLUMN_NAME)->text() ;
        if (((QCheckBox*) cellWidget(row,COLUMN_SHOW_EDIT))->isChecked())
        {
            result=result + "<field " + " name=\"" + item(row,COLUMN_NAME)->text() + "\"" +
                    " type=\"" + ((QComboBox*) cellWidget(row,9))->currentText()+ "\"" +
                    " default=\"\"" +
                    " label=\"" + "COM_LMNP_ADRESSE_" + item(row,COLUMN_NAME)->text() + "_LABEL" +"\"" +
                    " description=\"" + "COM_LMNP_ADRESSE_" + item(row,COLUMN_NAME)->text() + "_DESC" +"\"" +
                    " maxlength=\"" + item(row,2)->text() + "\""+
                    " required=\""  + ((QCheckBox*) cellWidget(row,7))->isChecked() + "\""+
                    //multiple="false" list="1"
                    // readonly="true"
                    + " />"
                    +"\n";
        }

    }

    return result;
}

QString TableModel::getPrimaryKey()
{
    QString result=NULL;
    int row;

    for (row=0;row < this->rowCount(); row++)
    {
        qDebug() << " primary key " << COLUMN_PRIMARY_KEY  <<  item(row,COLUMN_PRIMARY_KEY)->text() ;
        if ( item(row,COLUMN_PRIMARY_KEY)->text() == "PRI")
            return item(row,COLUMN_NAME)->text();
     }

    return result;
}

QString TableModel::getNullableFieldList()
{
    QStringList resultList;
    QString result;
    int row;

    for (row=0;row < this->rowCount(); row++)
    {
        if ( item(row,COLUMN_NULLABLE_FIELD)->text() == "YES")
           result.append(item(row,COLUMN_NAME)->text());
     }

    result = resultList.join(",");
    if (result == NULL)
        result ="rien";
    return result;
}


QString TableModel::getListFieldList()
{
    QStringList resultList;
    QString result;
    int row;

    for (row=0;row < this->rowCount(); row++)
    {
        if (((QCheckBox*) cellWidget(row,COLUMN_SHOW_LIST))->isChecked())
           result.append(item(row,COLUMN_NAME)->text());
     }

    result = resultList.join(",");
    if (result == NULL)
        result ="rien";
    return result;
}
/*
QString TableModel::fieldList()
{
    QString result=NULL;
    int row;

    for (row=0;row < this->rowCount(); row++)
    {
        if ( itemAt(row,COLUMN_PRIMARY_KEY)->text() == "PRI")
            return itemAt(row,COLUMN_NAME)->text();
     }

    return result;
}
*/
