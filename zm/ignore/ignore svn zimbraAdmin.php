<?php /*
-----------------------------
 urn:zimbraAdmin
-----------------------------

Attributes for all commands can have multiple values:

  <a n="name1">{value}</a>
  <a n="name2">{value}</a>  
  <a n="name1">{value}</a>  

Note that name1 appears twice. 

When updating multiple attributes, you need to specify all the old values at the same time you specify new ones.

----------------------------
 <AuthRequest xmlns="urn:zimbraAdmin">
   <name>...</name>
   <password>...</password>
 </AuthRequest>
 
 <AuthResponse>
   <authToken>...</authToken>
   <lifetime>...</lifetime>
 </AuthResponse>

Note: Only works with admin/domain-admin accounts

Access: domain admin sufficient
*/

----------------------------
 <DelegateAuthRequest xmlns="urn:zimbraAdmin" [duration="{duration}"]>
   <account by="id|name">...</account> 
 </DelegateAuthRequest>
 
 <DelegateAuthResponse>
   <authToken>...</authToken>
   <lifetime>...</lifetime>
 </DelegateAuthResponse>

Used to request a new auth token that is valid for the specified account. The id of the auth token will be the id of the target account,
and the requesting admin's id will be stored in the auth token for auditing purposes.

{duration} = lifetime in seconds of the newly-created authtoken. defaults to 1 hour. Can't be longer then zimbraAuthTokenLifetime.


/*
----------------------------
 
<CreateAccountRequest>
  <name>...</name>
  <password>...</password>*
  <a n="attr-name">...</a>+
</CreateAccountRequest>

<CreateAccountResponse>
  <account name="{name}" id="{id}">
    <a n="...">...</a>+
  </account>  
</CreateAccountResponse>

Notes:

  accounts without passwords can't be logged into

  name must include domain (uid@name), and domain specified in name must exist

  default value for zimbraAccountStatus is "active"  

Access: domain admin sufficient

-----------------------------

<GetAccountRequest [applyCos="{apply-cos}"]>
  <account by="id|name|foreignPrincipal">...</account>
</GetAccountRequest>

<GetAccountResponse>
  <account name="{name}" id="{id}">
    <a n="...">...</a>+
  </account>  
</GetAccountResponse>

{apply-cos} = 0|1 (1 is default)

 if {apply-cos} is 1, then COS rules apply and unset attrs on an account will get their value from the COS.

 if {apply-cos} is 0, then only attributes directly set on the account will be returned

Access: domain admin sufficient

-----------------------------

<GetAccountInfoRequest>
  <account by="id|name">...</account>
</GetAccountInfoRequest>
 
<GetAccountInfoResponse>
   <name>{account-name}</name>
   <a n="{name}">{value}</a>+
   <soapURL>{mail-url}</soapURL>+
   <adminSoapURL>{mail-url}</adminSoapURL>
</GetInfoResponse>
 
  {account-name} = email address (user@domain)

  {attrs} = account attrs. Currently only two attrs are returned:
  
      zimbraId       - the unique UUID of the zimbra account
      zimbraMailHost - the server on which this user's mail resides

  {mail-url} = URL to talk to for soap service for this account. i.e:
  
       http://server:7070/service/soap/

       Multiple URLs can be returned if both http and https (SSL) are enabled. If only one of the two is enabled,
       the only one URL will be returned.       

Access: domain admin sufficient
*/

-----------------------------

<GetAccountMembershipRequest>
  <account by="id|name|foreignPrincipal">...</account>
</GetAccountMembershipRequest>  

<GetAccountMembershipResponse>
    <dl name="{name}" id="{id}"  via="{via-dl-name}" />+
</GetAccountMembershipResponse>    

{via-dl-name} = is present if the account is a member of the returned list because they are either a direct
                or indirect member of another list that is a member of the returned list. For example,
                if a user is a member of engineering@domain.com, and engineering@domain.com is a member of all@domain.com,
                then <dl name="all@domain.com" ... via="engineering@domain.com"/> would be returned.

                
-----------------------------

<GetAllAdminAccountsRequest/>

<GetAllAdminAccountsResponse>
  <account name="{name}" id="{id}">
    <a n="...">...</a>+
  </account>  
</GetAllAdminAccountsResponse>

/*
-----------------------------

<ModifyAccountRequest>
  <id>{value-of-zimbraId}</id>
  <a n="...">...</a>+
</ModifyAccountRequest>

<ModifyAccountResponse>
  <account name="{name}" id="{id}">
    <a n="...">...</a>+
  </account>  
</ModifyAccountResponse>

Notes:

  an empty attribute value removes the specified attr

Access: domain admin sufficient. limited set of attributes that can be updated by a domain admin.

-----------------------------

<RenameAccountRequest>
  <id>{value-of-zimbraId}</id>
  <newName>{new-account-name}</newName>
</RenameAccountRequest>

<RenameAccountResponse>
  <account name="{name}" id="{id}">
    <a n="...">...</a>+
  </account>  
</RenameAccountResponse>

Access: domain admin sufficient

-----------------------------

<DeleteAccountRequest>
  <id>{value-of-zimbraId}</id>
</DeleteAccountRequest>

<DeleteAccountResponse/>

Deletes the account with the given id.  If the request is sent
to the server on which the mailbox resides, the mailbox is
deleted as well.

Access: domain admin sufficient

-----------------------------

<SetPasswordRequest>
  <id>{value-of-zimbraId}</id>
  <newPassword>...</newPassword>
</SetPasswordRequest>

<SetPasswordResponse/>

Access: domain admin sufficient
*/

-----------------------------

<CheckPasswordStrengthRequest>
  <id>{value-of-zimbraId}</id>
  <password>...</password>
</CheckPasswordStrengthRequest>

<CheckPasswordStrengthResponse/>

Access: domain admin sufficient

/*
-----------------------------

<AddAccountAliasRequest>
  <id>{value-of-zimbraId}</id>
  <alias>...</alias>
</AddAccountAliasRequest>

<AddAccountAliasResponse/>

Access: domain admin sufficient

-----------------------------

<RemoveAccountAliasRequest>
  <id>{value-of-zimbraId}</id>
  <alias>...</alias>
</RemoveAccountAliasRequest>

<RemoveAccountAliasResponse/>

Access: domain admin sufficient
*/
-----------------------------
NOTE: SearchAccountsRequest is deprecated. See SearchDirectoryRequest.

<SearchAccountsRequest [limit="..."] [offset="..."] [domain="{domain-name}"] [applyCos="{apply-cos}"]
         [attrs="a1,a2,a3"] [sortBy="{sort-by}"] [sortAscending="{sort-ascending}"] [types="{type}"]>
  <query>...</query>
</SearchAccountsRequest>

<SearchAccountsResponse more="{more-flag}" [searchTotal="{search-total}"]>
  <account name="{name}" id="{id}">
    <a n="...">...</a>+
  </account>
  <alias name="{name}" id="{id}">
    <a n="...">...</a>+  
  </alias>
  <dl name="{name}" id="{id}">  
    <a n="...">...</a>+  
  </dl>
</SearchAccountsResponse>

Notes:
SearchAccountsRequest
	<query> - query string should be an LDAP-style filter string (RFC 2254)
	limit - the number of accounts to return (0 is default and means all)
	offset - the starting offset (0, 25, etc)
	domain - the domain name to limit the search to
	applyCos - whether or not (0/1) to apply the COS policy to account. specify 0 if only
	           requesting attrs that aren't inherited from COS
	attrs - comma-seperated list of attrs to return ("displayName", "zimbraId", "zimbraAccountStatus")
	sortBy - name of attribute to sort on. default is the account name.
	sortAscending - whether to sort in ascending order (0/1), 1 is default
    more-flag = true if more accounts left to return
    search-total = total number of accounts that matched search (not affected by limit/offset)
    types = comma-separated list of types to return. legal values are: 
            accounts|distributionlists|aliases|resources|domains
            (default is accounts)

Access: domain admin sufficient (a domain admin can't specify "domains" as a type)

-----------------------------

 <AutoCompleteGalRequest domain="{domain}" [type="{type}"] limit="limit-returned">
   <name>...</name>
 </AutoCompleteGalRequest>
 
 <AutoCompleteGalResponse more="{more}">
   <cn>...</cn>*
 </AutoCompleteGalResponse>

  {limit} = an integer specifying the maximum number of results to return

  {type} = type of addresses to auto-complete on
           "account" for regular user accounts, aliases and distribution lists
           "resource" for calendar resources
           "all" for combination of both types
           if omitted, defaults to "accounts"
           
  {more-flag} = 1 if the results were truncated.

Notes: admin verison of mail equiv. Used for testing via zmprov.
  
-----------------------------
 <SearchGalRequest [type="{type}"]>
   <name>...</name>
 </SearchGalRequest>
 
 <SearchGalResponse more="{more}">
   <cn>...</cn>*
 </SearchGalResponse>

  {more-flag} = 1 if the results were truncated.

  {type} = type of addresses to search
           "account" for regular user accounts, aliases and distribution lists
           "resource" for calendar resources
           "all" for combination of both types
           if omitted, defaults to "all"
           
Notes: admin verison of mail equiv. Used for testing via zmprov.           

-----------------------------

<SearchDirectoryRequest [limit="..."] [offset="..."] [domain="{domain-name}"] [applyCos="{apply-cos}"] [maxResults="..."]
         [attrs="a1,a2,a3"] [sortBy="{sort-by}"] [sortAscending="{sort-ascending}"] [types="{type}"]>
  <query>...</query>
</SearchDirectoryRequest>

<SearchDirectoryResponse more="{more-flag}" [searchTotal="{search-total}"]>
  <account name="{name}" id="{id}">
    <a n="...">...</a>+
  </account>
  <alias name="{name}" id="{id}">
    <a n="...">...</a>+  
  </alias>
  <dl name="{name}" id="{id}">
    <a n="...">...</a>+  
  </dl>
  <domain name="{name}" id="{id}">
    <a n="...">...</a>+  
  </domain>  
</SearchDirectoryResponse>

Notes:
SearchDirectoryRequest
	<query> - query string should be an LDAP-style filter string (RFC 2254)
	maxResults = maximum results that the backend will attempt to fetch from the directory before
	returning a account.TOO_MANY_SEARCH_RESULTS error.

	limit - the number of accounts to return per page (0 is default and means all)
	offset - the starting offset (0, 25, etc)
	domain - the domain name to limit the search to (do not use if searching for domains)
	applyCos - whether or not (0/1) to apply the COS policy to account. specify 0 if only
	           requesting attrs that aren't inherited from COS
	attrs - comma-seperated list of attrs to return ("displayName", "zimbraId", "zimbraAccountStatus")
	sortBy - name of attribute to sort on. default is the account name.
	sortAscending - whether to sort in ascending order (0/1), 1 is default
    more-flag = true if more accounts left to return
    search-total = total number of accounts that matched search (not affected by limit/offset)
    types = comma-separated list of types to return. legal values are: 
            accounts|distributionlists|aliases|resources|domains
            (default is accounts)

Access: domain admin sufficient (though a domain admin can't specify "domains" as a type)
     
-----------------------------

<GetQuotaUsageRequest [limit="..."] [offset="..."] [domain="{limit-to-domain}"] 
         [sortBy="{sort-by}"] [sortAscending="{sort-ascending}"]]>
</GetQuotaUsageRequest>

<GetQuotaUsageResponse more="{more-flag}" [searchTotal="{search-total}"]>
  <account name="{name}" id="{id}" used="quota-used" limit="quota-limit"/>+
</GetQuotaUsageResponse>

Notes:
GetQuotaUsageRequest
  limit - the number of accounts to return (0 is default and means all)
  offset - the starting offset (0, 25, etc)
  domain - the domain name to limit the search to
  sortBy - valid values: "percentUsed", "totalUsed", "quotaLimit"
  sortAscending - whether to sort in ascending order (0/1), 0 is default, so highest quotas are returned first
  more-flag = true if more accounts left to return
  search-total = total number of accounts that matched search (not affected by limit/offset)
  used = used quota in bytes, or 0 if no quota used
  limit = quota limit in bytes, or 0 if unlimited

The target server should be specified in the soap header (see soap.txt, <targetServer>).

When sorting by "quotaLimit", 0 is treated as the highest value possible.

/*
-----------------------------

<GetAllAccountsRequest>
  [<domain by="id|name">...</domain>]
<GetAllAccountsRequest/>

<GetAllAccountsResponse>
  <account name="{name}" id="{id}">
    <a n="...">...</a>+
  </account>  
</GetAllAccountsResponse>

Access: domain admin sufficient

-----------------------------

<CreateDomainRequest>
  <name>...</name>
  <a n="...">...</a>+
</CreateDomainRequest>

<CreateDomainResponse>
  <domain name="{name}" id="{id}">
    <a n="...">...</a>+
  </domain>  
</CreateDomainResponse>

Notes:

  extra attrs:

  description
  zimbraNotes

-----------------------------

<GetDomainRequest [applyConfig="{apply-config}"]>
  <domain by="id|name|virtualHostname">...</domain> 
</GetDomainRequest>

<GetDomainResponse>
  <domain name="{name}" id="{id}">
    <a n="...">...</a>+
  </domain>
</GetDomainResponse>

{apply-config} = 0|1 (1 is default)

 if {apply-config} is 1, then certain unset attrs on an account will get their value from the global config.

 if {apply-config} is 0, then only attributes directly set on the server will be returned

-----------------------------

<GetAllDomainsRequest/>

<GetAllDomainsResponse>
  <domain name="{name}" id="{id}">  
    <a n="...">...</a>+
  </domain>+
</GetAllDomainsResponse>

-----------------------------

<ModifyDomainRequest>
  <id>{value-of-zimbraId}</id>
  <a n="...">...</a>+
</ModifyDomainRequest>

<ModifyDomainResponse>
  <domain name="{name}" id="{id}">
    <a n="...">...</a>+
  </domain>
</ModifyDomainResponse>

Notes:

  an empty attribute value removes the specified attr

-----------------------------

<DeleteDomainRequest>
  <id>{value-of-zimbraId}</id>
</DeleteDomainRequest>

<DeleteDomainResponse/>
*/

-----------------------------
<CreateCosRequest>
  <name>...</name>
  <a n="...">...</a>+
</CreateCosRequest>

<CreateCosResponse>
  <cos name="{name}" id="{id}">
    <a n="...">...</a>+
  </cos>
</CreateCosResponse>

Notes:

  extra attrs:

  description
  zimbraNotes

-----------------------------

<GetCosRequest>
  <cos by="id|name">...</cos>
</GetCosRequest>

<GetCosResponse>
  <cos name="{name}" id="{id}">
    <a [c="{cos-attr}"] n="...">...</a>+    
  </cos>
</GetCosResponse>

{cos-attr} = 0 (default) means the attrs applies to any account''s that belong to the cos
             1 means the attr applies only to the cos object itself

-----------------------------

<GetAllCosRequest/>

<GetAllCosResponse>
  <cos name="{name}" id="{id}">
    <a [c="{cos-attr}"] n="...">...</a>+    
  </cos>+  
</GetAllCosResponse>

-----------------------------

<ModifyCosRequest>
  <id>{value-of-zimbraId}</id>
  <a n="...">...</a>+
</ModifyCosRequest>

<ModifyCosResponse>
  <cos name="{name}" id="{id}">
    <a [c="{cos-attr}"] n="...">...</a>+    
  </cos>+  
</ModifyCosResponse>

Notes:

  an empty attribute value removes the specified attr

-----------------------------

<RenameCosRequest>
  <id>{value-of-zimbraId}</id>
  <newName>{new-cos-name}</newName>
</RenameCosRequest>

<RenameCosResponse>
  <cos name="{name}" id="{id}">
    <a n="...">...</a>+
  </cos>  
</RenameCosResponse>

-----------------------------

<DeleteCosRequest>
  <id>{value-of-zimbraId}</id>
</DeleteCosRequest>

<DeleteCosResponse/>

Notes:

  an empty attribute value removes the specified attr

/*
-----------------------------
<CreateServerRequest>
  <name>...</name>
  <a n="...">...</a>+
</CreateServerRequest>

<CreateServerResponse>
  <server name="{name}" id="{id}">
    <a n="...">...</a>+
  </server>
</CreateServerResponse>

Notes:

  extra attrs:

  description
  zimbraNotes

-----------------------------

<GetServerRequest [applyConfig="{apply-config}]">
  <server by="id|name|serviceHostname">...</server>
</GetServerRequest>

<GetServerResponse>
  <server name="{name}" id="{id}">
    <a n="...">...</a>+
  </server>
</GetServerResponse>

{apply-config} = 0|1 (1 is default)

by "serviceHostname" will return the server that has zimbraServiceHostname set to the specified value.

 if {apply-config} is 1, then certain unset attrs on an account will get their value from the global config.

 if {apply-config} is 0, then only attributes directly set on the server will be returned

-----------------------------

You can get all servers defined in the system or you can get all
servers that have a particular service enabled (eg, mta, antispam,
spell).

<GetAllServersRequest [service="service-name"]/>

<GetAllServersResponse>
  <server name="{name}" id="{id}">
    <a n="...">...</a>+
  </server>+
</GetAllServerResponse>

-----------------------------

<ModifyServerRequest>
  <id>{value-of-zimbraId}</id>
  <a n="...">...</a>+
</ModifyServerRequest>

<ModifyServerResponse>
  <server name="{name}" id="{id}">
    <a n="...">...</a>+
  </server>
</ModifyServerResponse>]

Notes:

  an empty attribute value removes the specified attr

-----------------------------

<DeleteServerRequest>
  <id>{value-of-zimbraId}</id>
</DeleteServerRequest>

<DeleteServerResponse/>

Notes:

  an empty attribute value removes the specified attr
*/
-----------------------------

<GetConfigRequest>
 <a n="....">
</GetServerRequest>

<GetConfigResponse>
  <a n="...">...</a>+
</GetConfigResponse>

-----------------------------
<GetAllConfigRequest/>

<GetAllConfigResponse>
  <a n="...">...</a>+
</GetAllConfigResponse>

-----------------------------
<ModifyConfigRequest>
  <a n="...">...</a>+
</ModifyConfigRequest>

<ModifyConfigResponse/>

Notes:

  an empty attribute value removes the specified attr

-----------------------------

<GetServerAggregateStatsRequest>
 <statName>...</statName>
 <startTime>{date-time}</startTime>
 <endTime>{date-time}</endTime>
 <period>...</period>
</GetServerAggregateStatsRequest>

<GetServerAggregateStatsResponse>
  <s n="..." t="{date-time}">{stat-value}</s>*
</GetServerAggregateStatsResponse>

{date-time} format is number of seconds in 1970, utc time.

-----------------------------
<GetServiceStatusRequest/>

<GetServiceStatusResponse>
<status server="..." service="..." t="{date-time}">{value}</status>*
</GetServiceStatusResponse>

{date-time} format is number of seconds in 1970, utc time.

-----------------------------

<PurgeMessagesRequest>
    [<mbox id="{account-id}"/>]
</PurgeMessagesRequest>

purges aged messages out of trash, spam, and entire mailbox
  (if <mbox> element is omitted, purges all mailboxes on server)
  
-----------------------------

<ReIndexRequest action="start|status|cancel">
  <mbox id="{account-id}" [types={types} | ids={ids}]/>
</ReIndexRequest>  

<ReIndexResponse status="started" | "running" | "cancelled">
  [<progress numSucceeded="SUCCEEDED" numFailed="FAILED" numRemaining="REMAINING">]
</ReIndexResponse>
   -- Progress data is currently ONLY returned by the "status" and "cancelled" calls

   -types -ids are optional, however at most ONE may be specified:
      {ids] = comma-separated list of IDs to re-index.  
      {types} 	= comma-separated list.  Legal values are:
                  conversation|message|contact|appointment|task|note|wiki|document
               
Access: domain admin sufficient

---------------------------

<DeleteMailboxRequest>
  <mbox id="{account-id}"/>
</DeleteMailboxRequest>

the request includes the account ID (uuid) of the target mailbox
on success, the response includes the mailbox ID (numeric) of the deleted mailbox
the <mbox> element is left out of the response if no mailbox existed for that account

<DeleteMailboxResponse>
  [<mbox mbxid="{mailbox-id}"/>]
</DeleteMailboxResponse>

Access: domain admin sufficient

-----------------------------
<GetMailboxRequest>
  <mbox id="{account-id}"/>
</GetMailboxRequest>

<GetMailboxResponse>
  <mbox mbxid="{mailbox-id}" s="{size-in-bytes}"/>
</GetMailboxResponse>

Access: domain admin sufficient

-----------------------------

Runs ANALYZE TABLE or OPTIMIZE TABLE on all tables that have grown
significantly since the last table maintenance.

<MaintainTablesRequest/>

<MaintainTablesResponse numTables="{number of tables maintained}"/>

-----------------------------

Runs the server-side unit test suite.

<UnitTesstRequest/>

<UnitTestsResponse numExecuted="{n}" numFailed="{n}">
    { Summary of test execution times and success/failure status }
</UnitTestsResponse>

-----------------------------
All the Check* SOAP calls potentially return the following two things:

<code>{code}</code>
<message>{message}</message>

where:

code is one of the following Strings:

 code                         description
 -------                      -----------
 check.OK                     everything went ok 
 check.UNKNOWN_HOST           unable to resolve a hostname
 check.CONNECTION_REFUSED     connection to a port was refused 
 check.SSL_HANDSHAKE_FAILURE  SSL connect problem, most likely untrusted certificate
 check.COMMUNICATION_FAILURE  generic communication failure
 check.AUTH_FAILED            authentication failed. invalid credentials (bad dn/password)
 check.AUTH_NOT_SUPPORTED     authentication flavor not supported. LDAP server probably 
                              configured to not allow passwords
 check.NAME_NOT_FOUND         unable to resolve an LDAP name. most likely invalid search base
 check.INVALID_SEARCH_FILTER  invalid ldap search filter
 check.FAILURE                generic failure

message is the detailed Java stack trace, used mainly for diagnosotics where the code
isn''t specific enough. Not user-friendly, but still useful for debugging problems.

Any SOAP faults returned indicate a problem with the request itself, not the thing being
checked.

----------------------------------------

<CheckHostnameResolveRequest>
 <hostname>...</hostname>
</CheckHostnameResolveRequest>

<CheckHostnameResolveResponse>
  <code>...</code>
  <message>...</message>*
</CheckHostnameResolveResponse>

------------------------------------------------------------

<CheckGalConfigRequest>
  <a n='zimbraGalMode'>ldap</a>
  <a n='zimbraGalLdapURL'>...</a>
  <a n='zimbraGalLdapSearchBase'>...</a>
  <a n='zimbraGalLdapFilter'>...</a>
  <a n='zimbraGalLdapBindDn'>...</a>*
  <a n='zimbraGalLdapBindPassword'>...</a>*
  <query limit="...">...</query>
</CheckGalConfigRequest>

<CheckGalConfigResponse>
  <code>...</code>
  <message>...</message>*
  <cn>...</cn>*
</CheckGalConfigResponse>

notes: 
 - zimbraGalMode must be set to ldap, even if you eventually want to set it to "both".
 - bindDn/bindPassword are optional if server allows anonymous binds

------------------------------------------------------------

<CheckAuthConfigRequest>
  <a n='zimbraAuthMech'>ldap</a>
  <a n='zimbraAuthLdapURL'>...</a>
  <a n='zimbraAuthLdapBindDn'>...</a>
  <a n='zimbraAuthLdapSearchFilter'>...</a>
  <a n='zimbraAuthLdapSearchBase'>...</a>
  <a n='zimbraAuthLdapSearchBindDn'>...</a>
  <a n='zimbraAuthLdapSearchBindPassword'>...</a>
  <name>...</name>
  <password>...</password>
</CheckAuthConfigRequest>

<CheckAuthConfigResponse>
  <code>...</code>
  <message>...</message>*
  <bindDn>{dn-computed-from-supplied-binddn-and-name}</bindDn>
</CheckAuthConfigResponse>

notes:
  - zimbraAuthMech must be set to ldap/ad. There is no reason to check zimbra.
  - zimbraAuthLdapURL must be set
  - either zimbraAuthLdapBindDn or zimbraAuthLdapSearchFilter must be set
  
  The following are optional, and only looked at if zimbraAuthLdapSearchFilter is set:
     - zimbraAuthLdapSearchBase is optional and defaults to ""
     - zimbraAuthLdapSearchBind{Dn,Password} are both optional
 
-----------------------------------

<CreateVolumeRequest>
  <volume type="..." name="..." rootpath="..."
          compressBlobs="..." compressionThreshold="..."/>
</CreateVolumeRequest>

<CreateVolumeResponse>
  <volume id="{id}"/>
</CreateVolumeResponse>

Notes:

  id: ID of volume
  type: type of volume;
        1 = primary message volume
        2 = secondary message volume
        10 = index volume
  name: name or description of volume
  rootPath: absolute path to root of volume, e.g. /opt/zimbra/store
  compressBlobs: boolean value that specifies whether blobs in this
    volume are compressed
  compressionThreshold: long value that specifies the maximum uncompressed
    file size, in bytes, of blobs that will not be compressed
    (in other words blobs larger than this threshold are compressed)

-----------------------------

<GetVolumeRequest id="{id}"/>

<GetVolumeResponse>
  <volume id="{id}" type="..." name="..." rootpath="..."
          compressBlobs="..." compressionThreshold="..."/>
</GetVolumeResponse>

-----------------------------

<GetAllVolumesRequest/>

<GetAllVolumesResponse>
  <volume .../>+  <!-- each volume element is same as in GetVolumeResponse -->
</GetAllVolumeResponse>

-----------------------------

<ModifyVolumeRequest id="{id}">
  <volume [type="..."] [name="..."] [rootpath="..."]
          [compressBlobs="..."] [compressionThreshold="..."]/>
</ModifyVolumeRequest>

<ModifyVolumeResponse/>

-----------------------------

<DeleteVolumeRequest id="{id}"/>

<DeleteVolumeResponse/>

-----------------------------

<GetCurrentVolumesRequest/>

<GetCurrentVolumesResponse>
  <volume type="1" id="{id}"/>
  [<volume type="2" id="{id}"/>]  <!-- optional -->
  <volume type="10" id="{id}"/>
</GetCurrentVolumesResponse>

-----------------------------

<SetCurrentVolumeRequest type="{type}" id="{id}"/>

<SetCurrentVolumeResponse/>

Notes:

  type: 1 (primary message), 2 (secondary message) or 10 (index)
  Each SetCurrentVolumeRequest can set only one current volume type.

-----------------------------

<CreateDistributionListRequest>
  <name>...</name>
  <a n="...">...</a>+
</CreateDistributionListRequest>

<CreateDistributionListResponse>
  <dl name="{name}" id="{id}">
    <a n="...">...</a>+
  </dl>  
</CreateDistributionListResponse>

Notes:

  extra attrs:

  description
  zimbraNotes

Access: domain admin sufficient

-----------------------------

<GetDistributionListRequest [limit="{limit}"] [offset="{offset}"]
                            [sortAscending="{sort-ascending}"]>
  <dl by="id|name">...</dl>
</GetDistributionListRequest>

<GetDistributionListResponse more="{more-flag}" [total="{total}"]>
  <dl name="{name}" id="{id}">
    <dlm>{member}</dlm>+
    <a n="...">...</a>+
  </dl>
</GetDistributionListResponse>

Notes:

    limit - the number of accounts to return (0 is default and means
            all)
    offset - the starting offset (0, 25, etc)
    sort-ascending - whether to sort in ascending order (0/1), 1 is
                     default

    more-flag = true if more accounts left to return
    total = total number of distribution lists (not affected by limit/offset)

Access: domain admin sufficient

-----------------------------

<GetAllDistributionListsRequest>
  [<domain by="id|name">...</domain>]
</GetAllDistributionListsRequest>

<GetAllDistributionListsResponse>
  <dl name="{name}" id="{id}">
    <a n="...">...</a>+
  </dl>
</GetAllDistributionListsResponse>

Access: domain admin sufficient

-----------------------------

<AddDistributionListMemberRequest>
  <id>{value-of-zimbraId}</id>
  <dlm>{member}</dlm>+
</AddDistributionListMemeberRequest>

<AddDistributionListMemberResponse>
</AddDistributionListMemeberResponse>

Access: domain admin sufficient

Adding existing members is allowed, even if it may result in this request
being a no-op because all <dlm> addrs are already members.

-----------------------------

<RemoveDistributionListMemberRequest>
  <id>{value-of-zimbraId}</id>
  <dlm>{member}</dlm>+
</RemoveDistributionListMemberRequest>

<RemoveDistributionListMemberResponse>
</RemoveDistributionListMemberResponse>

Access: domain admin sufficient

Unlike add, remove of a non-existent member causes an exception and no
modification to the list.

-----------------------------

<ModifyDistributionListRequest>
  <id>{value-of-zimbraId}</id>
  <a n="...">...</a>+
</ModifyDistributionListRequest>
  

<ModifyDistributionListResponse>
  <dl name="{name}" id="{id}">
    <a n="...">...</a>+
  </dl>
</ModifyDistributionListResponse>

Notes:

  an empty attribute value removes the specified attr

Access: domain admin sufficient

-----------------------------

<DeleteDistributionListRequest>
  <id>{value-of-zimbraId}</id>
</DeleteDistributionListRequest>

<DeleteDistributionListResponse/>

Access: domain admin sufficient

-----------------------------

<AddDistributionListAliasRequest>
  <id>{value-of-zimbraId}</id>
  <alias>...</alias>
</AddAliasRequest>

<AddDistributionListAliasResponse/>

Access: domain admin sufficient

-----------------------------

<RemoveDistributionListAliasRequest>
  <id>{value-of-zimbraId}</id>
  <alias>...</alias>
</RemoveDistributionListAliasRequest>

<RemoveDistributionListAliasResponse/>

Access: domain admin sufficient

-----------------------------

<RenameDistributionListRequest>
  <id>{value-of-zimbraId}</id>
  <newName>{new-account-name}</newName>
</RenameDistributionListRequest>

<RenameDistributionListResponse>
  <dl name="{name}" id="{id}">
    <a n="...">...</a>+
  </dl>  
</RenameDistributionListResponse>

Access: domain admin sufficient

-----------------------------

<GetDistributionListMembershipRequest>
  <dl by="id|name">...</dl>
</GetDistributionListMembershipRequest>  

<GetDistributionListMembershipResponse>
    <dl name="{name}" id="{id}"  via="{via-dl-name}" />+
</GetDistributionListMembershipResponse>    

{via-dl-name} = is present if the dl is a member of the returned list because they are either a direct
                or indirect member of another list that is a member of the returned list. For example,
                if a dl is a member of engineering@domain.com, and engineering@domain.com is a member of all@domain.com,
                then <dl name="all@domain.com" ... via="engineering@domain.com"/> would be returned.

-----------------------------

<GetClusterStatusRequest/>

<GetClusterStatusResponse>
  <clusterName>{cluster-name}</clusterName>	
  <servers>
    <server name="{server-name}" status="{1-or-0}"/>*
  </servers>
  <services>
    <service name="{service-name}" state="{state-string-from-console}"  owner="{server-name}" lastOwner="{server-name}" restarts="{number}"/>*
  </services>
</GetClusterStatusResponse>

-----------------------------

<FailoverClusterServiceRequest>
  <service name="{service-name}" newServer="{server-name}"/>
</FailOverClusterServiceRequest>

<FailoverCluserServiceResponse/>

-----------------------------

<GetVersionInfoRequest/>

<GetVersionInfoResponse>
  <info version="{version-string}" release="{release-string}" buildDate="{YYYYMMDD-hhmm}" buildHost="{host-name}"/>
</GetVersionInfoResponse>

-----------------------------

<GetLicenseInfoRequest/>

<GetLicenseInfoResponse>
  <expiration date={date-YYYYMMDD-format}></expiration>
</GetLicenseInfoResponse>

-----------------------------

<ConfigureZimletRequest>
  <content aid="{attachment-id}"/>
</ConfigureZimletRequest>

<ConfigureZimletResponse/>

-----------------------------

<DeployZimletRequest action="deployAll|deployLocal|status">
  <content aid="{attachment-id}"/>
<DeployZimletRequest/>

<DeployZimletResponse>
  [<progress server="{server-name}" status="succeeded|failed|pending"/>]+
</DeployZimletResponse>

-----------------------------

# priority is listed in the global list <zimlets> ... </zimlets> only.
# that's because the priority value is relative to other Zimlets in the list.
# the same Zimlet may show different priority number depending on what other
# Zimlets priorities are.  the same Zimlet will show priority 0 if all by itself,
# or priority 3 if there are three other Zimlets with higher priority.

<GetZimletStatusRequest/>

<GetZimletStatusResponse>
  <zimlets>
    <zimlet name="{zimlet-name}" priority="int" extension="true/false" status="enabled/disabled"/>
    ...
  </zimlets>
  <cos name="default">
    <zimlet name="{zimlet-name}" extension="true/false" status="enabled/disabled"/>
    ...
  </cos>
  ...
</GetZimletStatusResponse>

-----------------------------

# returns the admin extension addon Zimlets.

<GetAdminExtensionZimletsRequest/>

<GetAdminExtensionZimletsResponse>
  <zimlets>
    <zimlet>
      <zimletContext baseUrl="..."/>
      <zimlet extension="true" version="{version-string}" name="{zimlet-name}" description="{zimlet-description}">
        <include>...</include>+
      </zimlet>
    </zimlet>
  </zimlets>
</GetAdminExtensionZimletsResponse>

-----------------------------

<ModifyZimletRequest>
  <zimlet name="{zimlet-name}">
    [<status [value="enabled/disabled"]/>]
    [<acl [cos="{cos-name}" acl="grant/deny"]/>]
    [<priority [value="integer"]/>]
  </zimlet>
</ModifyZimletRequest>

<ModifyZimletResponse/>

-----------------------------

<UndeployZimletRequest name="{zimlet-name}"/>

<UndeployZimletResponse/>

-----------------------------

<GetZimletRequest>
  <zimlet name="{zimlet-name}"/>
</GetZimletRequest>

<GetZimletResponse>
  <zimlet name="{name}" id="{id}">
    <a n="...">...</a>+
  </zimlet>
</GetZimletResponse>

-----------------------------

<GetAllZimletsRequest exclude="{exclude}"/>

<GetAllZimletsResponse>
  <zimlet name="{name}" id="{id}">
    <a n="...">...</a>+
  </zimlet>+
</GetAllZimletsResponse>

Notes:
	{exclude} can be "none|extension|mail"
	when exclude="extension" is specified the response returns only mail Zimlets
	when exclude="mail" is specified the response returns only admin extensions
	when exclude = "none" both mail and admin zimlets are returned
	
	default is "none"
-----------------------------

<CreateZimletRequest>
  <name>...</name>
  <a n="...">...</a>+
</CreateZimletRequest>

<CreateZimletResponse>
  <zimlet name="{name}" id="{id}">
    <a n="...">...</a>+
  </zimlet>
</CreateZimletResponse>

-----------------------------

<DeleteZimletRequest>
  <zimlet name="{zimlet-name}"/>
</DeleteZimletRequest>

<DeleteZimletResponse/>

-----------------------------

<DumpSessionsRequest>

<DumpSessionsResponse>
   Session State Dump
</DumpSessionsResponse>

If accountName is unvailable for some reason, it will be set to the same as accountId.

-----------------------------

Note: Calendar resource is a special type of Account.  The Create, Delete,
Modify, Rename, Get, GetAll, and Search operations are very similar to
those of Account.


<CreateCalendarResourceRequest>
  <name>...</name>
  <password>...</password>*
  <a n="attr-name">...</a>+
</CreateCalendarResourceRequest>

<CreateCalendarResourceResponse>
  <calresource name="{name}" id="{id}">
    <a n="...">...</a>+
  </calresource>  
</CreateCalendarResourceResponse>

Notes:

  name must include domain (uid@name), and domain specified in name must exist

  a calendar resource does not have a password (you can''t login as a resource)

Access: domain admin sufficient

-----------------------------

<DeleteCalendarResourceRequest>
  <id>{value-of-zimbraId}</id>
</DeleteCalendarResourceRequest>

<DeleteCalendarResourceResponse/>

Access: domain admin sufficient

-----------------------------

<ModifyCalendarResourceRequest>
  <id>{value-of-zimbraId}</id>
  <a n="...">...</a>+
</ModifyCalendarResourceRequest>

<ModifyCalendarResourceResponse>
  <calresource name="{name}" id="{id}">
    <a n="...">...</a>+
  </calresource>  
</ModifyCalendarResourceResponse>

Notes:

  an empty attribute value removes the specified attr

Access: domain admin sufficient. limited set of attributes that can be updated by a domain admin.

-----------------------------

<RenameCalendarResourceRequest>
  <id>{value-of-zimbraId}</id>
  <newName>{new-resource-name}</newName>
</RenameCalendarResourceRequest>

<RenameCalendarResourceResponse>
  <calresource name="{name}" id="{id}">
    <a n="...">...</a>+
  </calresource>  
</RenameCalendarResourceResponse>

Access: domain admin sufficient

-----------------------------

<GetCalendarResourceRequest [applyCos="{apply-cos}"]>
  <calresource by="id|name|foreignPrincipal">...</calresource>
</GetCalendarResourceRequest>

<GetCalendarResourceResponse>
  <calresource name="{name}" id="{id}">
    <a n="...">...</a>+
  </calresource>  
</GetCalendarResourceResponse>

{apply-cos} = 0|1 (1 is default)

 if {apply-cos} is 1, then COS rules apply and unset attrs on the calendar resource will get their value from the COS.

 if {apply-cos} is 0, then only attributes directly set on the calendar resource will be returned

Access: domain admin sufficient

-----------------------------

<GetAllCalendarResourcesRequest>
  [<domain by="id|name">...</domain>]
<GetAllCalendarResourcesRequest/>

<GetAllCalendarResourcesResponse>
  <calresource name="{name}" id="{id}">
    <a n="...">...</a>+
  </calresource>  
</GetAllCalendarResourcesResponse>

Access: domain admin sufficient

-----------------------------

<SearchCalendarResourcesRequest [limit="..."] [offset="..."] [domain="{domain-name}"] [applyCos="{apply-cos}"]
         [attrs="a1,a2,a3"] [sortBy="{sort-by}"] [sortAscending="{sort-ascending}"] >
  <searchFilter> ... </searchFilter>
</SearchCalendarResourcesRequest>

<SearchCalendarResourcesResponse more="{more-flag}" [searchTotal="{search-total}"]>
  <calresource name="{name}" id="{id}">
    <a n="...">...</a>+
  </calresource>
</SearchCalendarResourcesResponse>

Notes:
SearchCalendarResourcesRequest
	limit - the number of calendar resources to return (0 is default and means all)
	offset - the starting offset (0, 25, etc)
	domain - the domain name to limit the search to
	applyCos - whether or not (0/1) to apply the COS policy to calendar resource. specify 0 if only
	           requesting attrs that aren''t inherited from COS
	attrs - comma-seperated list of attrs to return ("displayName", "zimbraId", "zimbraAccountStatus")
	sortBy - name of attribute to sort on. default is the calendar resource name.
	sortAscending - whether to sort in ascending order (0/1), 1 is default
    more-flag = true if more calendar resources left to return
    search-total = total number of calendar resources that matched search (not affected by limit/offset)

searchFilter: See SearchCalendarResourcesRequest section in soap.txt.

Access: domain admin sufficient

-----------------------------

Get a count of all the mail queues by counting the number of files in
the queue directories.  Note that the admin server waits for queue
counting to complete before responding - client should invoke requests
for different servers in parallel.

<GetMailQueueInfoRequest>
  <server name="{mta-server}"/>
</GetMailQueueInfoRequest>

<GetMailQueueInfoResponse/>
  <server name="{mta-server}">
    <queue name="deferred" n="{N}"/>
    <queue name="incoming" n="{N}"/>
    <queue name="active" n="{N}"/>
    <queue name="hold" n="{N}"/>
    <queue name="corrupt" n="{N}"/>
  </server>
</GetMailQueueInfoResponse>

-----------------------------

Summarize and/or search a particular mail queue on a particular
server.  The admin SOAP server initiates a MTA queue scan (via ssh)
and then caches the result of the queue scan.  To force a queue scan,
specify scan=1 in the request.

The response has two parts.

- <qs> elements summarize queue by various types of data (sender
  addresss, recipient domain, etc).  Only the deferred queue has error
  summary type.

- <qi> elements list the various queue items that match the requested
  query.

The stale-flag in the response means that since the scan, some queue
action was done and the data being presented is now stale.  This
allows us to let the user dictate when to do a queue scan.

The scan-flag in the response indicates that the server has not
completed scanning the MTA queue, and that this scan is in progress,
and the client should ask again in a little while.

The more-flag in the response indicates that more qi''s are available
past the limit specified in the request.

<GetMailQueueRequest>
  <server name="{mta-server}">
    <queue name="{queue-name}" [scan="{0,1}"] [wait={seconds}]>
      <query [offset={offset}] [limit={limit}]>
          <field name="{field1}">
              <match value="{value1}"/>     # OR's all values
              <match value="{value2}"/>
              <match value="{value3}"/>
          </field>
          <field name="{field2}">           # AND's all fields
              <match value="{value3}"/>
              <match value="{value5}"/>
          </field>
      </query>
    </queue>
  </server>
<GetMailQueueRequest>

<GetMailQueueResponse>
  <server name="{mta-server}">
    <queue name="{queue-name}" stale="{stale-flag}" time="{scan-time}" more="{more-flag}" scan="{scan-flag} total="{total}">

      <qs type="reason|to|from|todomain|fromdomain|addr|host">
        <qsi n="{count}" t="{text-for-item}">+
      </qs>+

      <qi id="{id}" from="{sender}" to="{recipients-comma-seperated}"
          time="{arrival-time}" filter="{content-filter}"
          addr="{origin-ip-address} host="{origin-host-name}"/>+
    </queue>
  </server>
</GetMailQueueResponse>

Example of qs node is:

   <qs type="fromdomain">
      <item n="10" t="yahoo.com"/>
      <item n="10" t="google.com"/>
   </qs>

   <qs type="reason">
      <item n="10" t="connect to 10.10.20.40 failed"/>
      <item n="10" t="connect to 10.10.20.50 timed out"/>
   </qs>

Example of qi nodes:

   <qi id="ABCDEF1234" 
       from="jack@example.com" 
       to="foo@example.com,bar@example.com"
       time="1142622329"  XXX - should this be in milliseconds?
       filter="smtp-amavis:[127.0.0.1]:10024"
       addr="10.10.130.27"
       host="phillip.liquidsys.com">

-----------------------------

Command to act on invidual queue files.  This proxies through to
postsuper.  list-of-ids can be ALL.

<MailQueueActionRequest>
  <server name="{mta-server}">
     <queue name="{queue-name}">
       <action op="delete|hold|release|requeue"/ by="id|query">
               {list-of-ids|}
          ||
               {<query> # just like GetMailQueue
                  <field name="name">
                    <match value="val"/>
                  </field>
                </query>}
       </action>
     </queue>
  </server>
</MailQueueActionRequest>

<MailQueueActionResponse>
  - response is same as GetMailQueueResponse above.
</MailQueueActionResponse>

-----------------------------

Command to invoke postqueue -f.  All queues cached in the server are
are stale after invoking this because this is a global operation to
all the queues in a given server.

<MailQueueFlushRequest>
  <server name="{mta-server}">
</MailQueueFlushRequest>

<MailQueueFlushResponse/>

-----------------------------

Initializes the Notebook account used for public folder and templates.

{template-dir} is a directory on the server that contains the Wiki
templates.  {template-folder} is a folder in the Mailbox that
the templates are being imported to.  The default value of {template-folder}
is "Template" folder.  

When the element template is present in the request,
the server will populate the template directory of the account
with the template files in the directory.

If the optional element domain is present, it will create the domain
level wiki account used for public wiki folder for the domain.

If the optional element account is present, the value will be used to
create the account, and then sets either zimbraNotebookDefaultAccount
or zimbraNotebookDomainAccount LDAP attribute.

<InitNotebookRequest>
  [<template dest="{template-folder}">{template-dir}</template>]
  [<name>...</name>]
  [<password>...</password>]
  [<domain by="id|name">...</domain>]
</InitNotebookRequest>

<InitNotebookResponse/>

-----------------------------

<CreateDataSourceRequest/>
  <id>{account-id}</id>
  <dataSource type="pop3" name="{data-source-name}">
   <a n="zimbraDataSourceName">My POP3 Account</a>
   <a n="zimbraDataSourceIsEnabled">TRUE</a>
   <a n="zimbraDataSourceHost">pop.myisp.com</a>
   <a n="zimbraDataSourcePort">110</a>
   <a n="zimbraDataSourceUsername">mylogin</a>
   <a n="zimbraDataSourcePassword">mypassword</a>
   <a n="zimbraDataSourceFolderId">{folder-id}</a>
  </dataSource>
</CreateDataSourceRequest>

<CreateDataSourceResponse>
  <dataSource type="{type}" name="..." id="...">
   <a n="...">{value}</a>+
  </dataSource>
</CreateDataSourceResponse>

Creates a data source that imports mail items into the specified folder.  Currently
the only type supported is pop3.

every attribute value is returned except password.

---------------------------

<GetDataSourcesRequest>
  <id>{account-id}</id>
</GetDataSourcesRequest>

<GetDataSourcesResponse>

  <dataSource type="{type}" name="..." id="...">
   <a n="...">{value}</a>+
  </dataSource>
  ...
</GetDataSourcesResponse>

Returns all data sources defined for the given mailbox.  For each data source,
every attribute value is returned except password.

---------------------------

<ModifyDataSourceRequest>
  <id>{account-id}</id>
  <dataSource id="{id}">
   <a n="...">{value}</a>+
  </dataSource>
</ModifyDataSourceRequest>

<ModifyDataSourceResponse/>

Changes attributes of the given data source.  Only the attributes specified in the request
are modified. To change the name, specify "zimbraDataSourceName" as an attribute.

---------------------------

<DeleteDataSourceRequest>
  <id>{account-id}</id>
  <dataSource id="{id}"/>
</DeleteDataSourceRequest>

<DeleteDataSourceResponse/>

Deletes the given data source.

---------------------------

<FixCalendarTimeZoneRequest
  [sync="0|1"]      // default 0
                    // 0 = command returns right away
                    // 1 = command blocks until processing finishes
  [after="millis"]  // fix appts/tasks that have instances after this time
                    // default = January 1, 2007 00:00:00 in GMT+13:00 timezone.
  [country="CC"]    // CC = ISO-3316 two-letter country code
                    // Null by default, meaning world.
                    // Only other value possible is "AU", for Australia.
>
  <account name="<email>|all"/>+  // list of email addresses, or "all" for all
                                  // accounts on this mailbox server
</FixCalendarTimeZoneRequest>

<FixCalendarTimeZoneResponse/>

Fix timezone definitions in appointments and tasks to reflect changes in
daylight savings time rules in various timezones.

---------------------------

WaitSet: scalable mechanism for listening for changes to one or more accounts 

INTEREST_TYPES: comma-separated list.  Start with:
   c: contacts
   m: msgs (and subclasses)
   a: all


*************************************
CreateWaitSet: must be called once to initialize the WaitSet
and to set its "default interest types"
************************************* 
<CreateWaitSetRequest defTypes="DEFAULT INTEREST_TYPES">
  [ <add>
      [<a id="ACCTID" [token="lastKnownSyncToken"] [types="if_not_default"]/>]+
    </add> ]
</CreateWaitSetRequest>

<CreateWaitSetResponse waitSet="setId" defTypes="types" seq="0">
  [ <error ...something.../>]*
</CreateWaitSetResponse>  


************************************
WaitMultipleAccounts:  optionally modifies the wait set and checks
for any notifications.  If block=1 and there are no notificatins, then
this API will BLOCK until there is data.

Client should always set 'seq' to be the highest known value it has
received from the server.  The server will use this information to
retransmit lost data.

If the client sends a last known sync token then the notification is
calculated by comparing the accounts current token with the client''s
last known.

If the client does not send a last known sync token, then notification
is based on change since last Wait (or change since <add> if this
is the first time Wait has been called with the account)
*************************************
<WaitMultipleAccountsRequest waitSet="setId" seq="highestSeqKnown" [block="1"]>
  [ <add>
      [<a id="ACCTID" [token="lastKnownSyncToken"] [types]/>]+
    </add> ]
  [ <update>
      [<a id="ACCTID" [token="lastKnownSyncToken"] [types]/>]+
    </update> ]  
  [ <remove>
      [<a id="ACCTID"/>]+
    </remove> ]  
</WaitMultipleAccountsRequest>

<WaitMultipleAccountsResponse waitSet="setId" [seq="seqNo" OR canceled="1"]>
  [ <n id="ACCTID"/>]*
  [ <error ...something.../>]*
</WaitMultipleAccountsResponse>

If the specified wait set does not exist, the server will throw an
admin.NO_SUCH_WAITSET exception.

NOTE: an empty response to a blocking request *is* possible: it would
happen if the server timed-out the waiting.  The server does this
occasionally just so that requests don''t get "stuck".  The client
should re-submit the original request if this happens.

If a second WaitMultiple request arrives at the server while one is
already waiting, the first request will be immediately completed and
will return with the "canceled" flag set.




*************************************
DestroyWaitSet: Use this to close out the wait set.  Note that the
server will automatically time out a wait set if there is no reference
to it for (default of) 10 minutes.
*************************************
<DestroyWaitSetRequest waitSet="setId"/>

<DestroyWaitSetResponse waitSet="setId"/>


**********************************************************************
 Example Interaction:
**********************************************************************

<CreateWaitSetRequest defTypes="c">
  <add>
    <a id="a1"/>
  </add>  
</CreateWaitSetRequest>
<!-- a1 receives a contact update -->
<CreateWaitSetResponse waitSet="foo" defTypes="c" seq="0"/>

<!--client syncs to a1 state AFTER added to WaitSet (not using sync token) -->
<!-- a3 receives a contact update (token goes to 100)-->
<!--client syncs to a3 BEFORE adding to WaitSet (client has token 100) -->

<WaitMultipleAccountsRequest waitSet="foo" seq="0" block="1">
  <add>
    <a id="a3" token="100"/>
  </add>
</WaitMultipleAccountsRequest>
<!-- Will return *immediately* b/c a1 has changed since the <add> -->
<WaitMultipleAccountsResponse waitSet="foo" seq="1">
  <n id="a1"/>
</WaitMultipleAccountsResponse>

<!-- At this point, client *must* sync with a1, even though the a1 update might have
     happened before we synched with a1 there is no way to know.  a3 is not notified
     and does not have to sync, because it is using sync tokens.  -->

<WaitMultipleAccountsRequest waitSet="foo" seq="1" block="1">
  <add>
    <a id="a2"/>
  </add>
</WaitMultipleAccountsRequest>
<!-- the client must sync with a2 state AFTER setting a2 wait, however because
     block="1" the wait will not return until some account has new data: therefore
     the client MUST sync a2 using another thread here.  The client cannot sync
     before doing the <add> because of race conditions.  If the client is not
     multi-threaded, then it should issue the <add> as block="0" in this case -->
<!-- ...BLOCKS until... -->
<!-- a3 receives a contact update (sync token goes to 107) -->
<WaitMultipleAccountsResponse waitSet="foo" seq="2">
  <n id="a3"/>
</WaitMultipleAccountsResponse>

<!-- client syncs to a3 -->

<WaitMultipleAccountsRequest waitSet="foo" seq="2" block="1"/>
<!-- This is an example of a programming bug, the client has synched
     to a3, but has not updated the last known token state with the server!
     Immediately we are re-notified for a3, b/c the server still thinks client is at
     syncToken 100 -->
<WaitMultipleAccountsResponse waitSet="foo" seq="3">
  <n id="a3"/>
</WaitMultipleAccountsResponse>

<!-- client syncs to a3 -->

<WaitMultipleAccountsRequest waitSet="foo" seq="3" block="1">
  <update>
    <a id="a3" token="107"/>
  </update>  
</WaitMultipleAccountsRequest>
  
<!-- Client is up to date, server  blocks until there is new data 
     on a1,a2 or a3 -->
  
  
---------------------------

# returns admin saved searches.

<GetAdminSavedSearchesRequest>
  <search name="{search-name}"/>*
</GetAdminSavedSearchesRequest>
  
  If no <search> is present server will return all saved searches.

<GetAdminSavedSearchesResponse>
  <search name="{search-name}">{{search-query}}</search>*
</GetAdminSavedSearchesResponse>

---------------------------

# modifies admin saved searches.

# returns the admin saved searches.
<ModifyAdminSavedSearchesRequest>
  {<search name="{search-name}">{search-query}</search>}+
</ModifyAdminSavedSearchesRequest>

  If {search-query} is empty => delete the search if it exists
  If {search-name} already exists => replace with new {search-query}
  If {search-name} does not exist => save as a new search

<ModifyAdminSavedSearchesResponse/>

-----------------------------
