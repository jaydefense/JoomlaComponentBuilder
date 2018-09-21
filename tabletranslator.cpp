#include "tabletranslator.h"

TableTranslator::TableTranslator(QWidget *parent) :
    QTableWidget(parent)
{
    this->componantName = "com_lmnp";
    this->prefix="lmnp_";
    QString str=tr("Code,Valeur,Site,Admin,Adm.Sys");
    QStringList labels = str.split(",");
    setColumnCount(labels.size());
    setHorizontalHeaderLabels(labels);
}





void TableTranslator::AddLine(QString table, QString column, QString type,QString value, bool site, bool admin, bool admSys  )
{
    int row=0,col=0;
    QTableWidgetItem *item;
    QString key;

    key = componantName + "_" + table.replace(prefix,"") +"_" + column + "_" + type;
    key= key.toUpper();
    row = rowCount();
    insertRow(row);

    item = new QTableWidgetItem(key,0);
    setItem(row,col++,item);

    item = new QTableWidgetItem(value,2);
    setItem(row,col++,item);
}

QString TableTranslator::toStringLanguage()
{
    QString result="";
    int row;

    for (row=0;row < this->rowCount(); row++)
    {
            result=result + item(row,0)->text() + "=" +
                            item(row,1)->text() +"\n";

    }

    return result;
}
