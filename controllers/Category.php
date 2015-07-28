<?php

Class Category
{
    public function run()
    {
        $query = MQueries::selectQuery('select
ARL_ART_ID as article_id,
BRANDD as detail_brand,
ARL_SEARCH_NUMBER as detail_search_number,
ART_COMPLETE_DES_TEXT as russian_detail_name,
TYP_ID as auto_model_type_id,
MFA_BRAND as auto_model_brand,
dtTEXT as auto_model_type_small,
TEX_TEXT as auto_model_type_full
from (select
b.BRA_ID,
IF (al.ARL_KIND IN (3, 4), b.BRA_BRAND, sup.SUP_BRAND) AS BRANDD,
t.TYP_ID,
al.ARL_ART_ID,
al.ARL_SEARCH_NUMBER,
a.ART_DES_ID,
des.DES_ID,
dest.TEX_TEXT AS ART_COMPLETE_DES_TEXT,
ma.MFA_BRAND,
dt.TEX_TEXT as dtTEXT,
dt2.*
from
ART_LOOKUP al
left join BRANDS b on b.BRA_ID=al.ARL_BRA_ID
left join ARTICLES a on a.ART_ID=al.ARL_ART_ID
left JOIN SUPPLIERS sup ON sup.SUP_ID = a.ART_SUP_ID
left JOIN DESIGNATIONS des ON des.DES_ID = a.ART_COMPLETE_DES_ID
left JOIN DESIGNATIONS des2 ON des2.DES_ID = a.ART_DES_ID
left JOIN DES_TEXTS dest ON dest.TEX_ID = des.DES_TEX_ID
left join LINK_ART la on la.LA_ART_ID=a.ART_ID
left join LINK_LA_TYP lt on lt.LAT_LA_ID=la.LA_ID
left join TYPES t on t.TYP_ID=lt.LAT_TYP_ID
left join MODELS m on m.MOD_ID=t.TYP_MOD_ID
left join MANUFACTURERS ma on ma.MFA_ID=m.MOD_MFA_ID
left join COUNTRY_DESIGNATIONS cd on cd.CDS_ID=t.TYP_CDS_ID && cd.CDS_LNG_ID=16
left join DES_TEXTS dt on dt.TEX_ID=cd.CDS_TEX_ID
left join COUNTRY_DESIGNATIONS cd2 on cd2.CDS_ID=t.TYP_MMT_CDS_ID && cd.CDS_LNG_ID=16
left join DES_TEXTS dt2 on dt2.TEX_ID=cd2.CDS_TEX_ID
where al.ARL_SEARCH_NUMBER=\'MA689\' && des.DES_LNG_ID=16
group by al.ARL_ART_ID) main
group by TEX_ID');
        var_dump($query);

    }
}