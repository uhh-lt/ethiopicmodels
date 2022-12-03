import re

def find_url(string): 
    text = re.findall('http[s]?://(?:[a-zA-Z]|[0-9]|[$-_@.&+]|[!*\(\),]|(?:%[0-9a-fA-F][0-9a-fA-F]))+',string)
    return "".join(text) # converting return value from list to string
def remove_url(data):
    return data.replace(find_url(data),"")
def remove_eng(data):
    return ' '.join(re.sub(u"[^ሀ-፼]", " ", data).split()).strip()
def remove_emoji(news):
    news = emoji.demojize(news)
    re.sub('(:\S+)(@\w+)','', news)
    return news
def duplicated_values_data(data):
    dup=[]
    columns=data.columns
    for i in data.columns:
        dup.append(sum(data[i].duplicated()))
    return pd.concat([pd.Series(columns),pd.Series(dup)],axis=1,keys=['Columns','Duplicate count'])