
[x] https://api.dotmailer.com/v2/account-info	GET
[x] https://api.dotmailer.com/v2/address-books	POST
[x] https://api.dotmailer.com/v2/address-books/{addressBookId}/campaigns?select={select}&skip={skip}	GET
[x] https://api.dotmailer.com/v2/address-books/{addressBookId}/contacts	DELETE
[x] https://api.dotmailer.com/v2/address-books/{addressBookId}/contacts POST
[x] https://api.dotmailer.com/v2/address-books/{addressBookId}/contacts/{contactId}	DELETE
[x] https://api.dotmailer.com/v2/address-books/{addressBookId}/contacts/delete	POST
[ ] https://api.dotmailer.com/v2/address-books/{addressBookId}/contacts/import	POST
[x] https://api.dotmailer.com/v2/address-books/{addressBookId}/contacts/modified-since/{date}?withFullData={withFullData}&select={select}&skip={skip}	GET
[x] https://api.dotmailer.com/v2/address-books/{addressBookId}/contacts/resubscribe	POST
[x] https://api.dotmailer.com/v2/address-books/{addressBookId}/contacts/unsubscribe	POST
[x] https://api.dotmailer.com/v2/address-books/{addressBookId}/contacts/unsubscribed-since/{date}?select={select}&skip={skip}	GET
[x] https://api.dotmailer.com/v2/address-books/{addressBookId}/contacts?withFullData={withFullData}&select={select}&skip={skip}	GET
[x] https://api.dotmailer.com/v2/address-books/{id}	GET
[x] https://api.dotmailer.com/v2/address-books/{id} PUT
[x] https://api.dotmailer.com/v2/address-books/{id} DELETE
[x] https://api.dotmailer.com/v2/address-books/private?select={select}&skip={skip}	GET
[x] https://api.dotmailer.com/v2/address-books/public?select={select}&skip={skip}	GET
[x] https://api.dotmailer.com/v2/address-books?select={select}&skip={skip}	GET
[x] https://api.dotmailer.com/v2/campaigns	POST
[x] https://api.dotmailer.com/v2/campaigns/{campaignId}/activities/{contactId}	GET
[x] https://api.dotmailer.com/v2/campaigns/{campaignId}/activities/{contactId}/clicks?select={select}&skip={skip}	GET
[x] https://api.dotmailer.com/v2/campaigns/{campaignId}/activities/{contactId}/opens?select={select}&skip={skip}	GET
[x] https://api.dotmailer.com/v2/campaigns/{campaignId}/activities/{contactId}/page-views?select={select}&skip={skip}	GET
[x] https://api.dotmailer.com/v2/campaigns/{campaignId}/activities/{contactId}/replies?select={select}&skip={skip}	GET
[x] https://api.dotmailer.com/v2/campaigns/{campaignId}/activities/{contactId}/roi-details?select={select}&skip={skip}	GET
[x]https://api.dotmailer.com/v2/campaigns/{campaignId}/activities/{contactId}/social-bookmark-views?select={select}&skip={skip} GET
[x] https://api.dotmailer.com/v2/campaigns/{campaignId}/activities/since-date/{date}?select={select}&skip={skip}	GET
[x] https://api.dotmailer.com/v2/campaigns/{campaignId}/activities?select={select}&skip={skip}	GET
[x] https://api.dotmailer.com/v2/campaigns/{campaignId}/address-books?select={select}&skip={skip}	GET
[?] https://api.dotmailer.com/v2/campaigns/{campaignId}/attachments	GET
[?] https://api.dotmailer.com/v2/campaigns/{campaignId}/attachments	POST
[?] https://api.dotmailer.com/v2/campaigns/{campaignId}/attachments/{documentId}	DELETE
[x] https://api.dotmailer.com/v2/campaigns/{campaignId}/clicks?select={select}&skip={skip}	GET
[ ] https://api.dotmailer.com/v2/campaigns/{campaignId}/copy	POST
[ ] https://api.dotmailer.com/v2/campaigns/{campaignId}/hard-bouncing-contacts?withFullData={withFullData}&select={select}&skip={skip}	GET
[x] https://api.dotmailer.com/v2/campaigns/{campaignId}/opens?select={select}&skip={skip}	GET
[x] https://api.dotmailer.com/v2/campaigns/{campaignId}/page-views/since-date/{date}?select={select}&skip={skip}	GET
[x] https://api.dotmailer.com/v2/campaigns/{campaignId}/roi-details/since-date/{date}?select={select}&skip={skip}	GET
[x] https://api.dotmailer.com/v2/campaigns/{campaignId}/social-bookmark-views?select={select}&skip={skip}	GET
[x] https://api.dotmailer.com/v2/campaigns/{campaignId}/summary	GET
[x] https://api.dotmailer.com/v2/campaigns/{id}	GET
[x] https://api.dotmailer.com/v2/campaigns/{id}	PUT
[ ] https://api.dotmailer.com/v2/campaigns/send	POST
[ ] https://api.dotmailer.com/v2/campaigns/send/{sendId}	GET
[x] https://api.dotmailer.com/v2/campaigns/with-activity-since/{date}?select={select}&skip={skip}	GET
[x] https://api.dotmailer.com/v2/campaigns?select={select}&skip={skip}	GET
[x] https://api.dotmailer.com/v2/contacts	POST
[x] https://api.dotmailer.com/v2/contacts/{contactId}/address-books?select={select}&skip={skip}	GET
[x] https://api.dotmailer.com/v2/contacts/{email}	GET
[ ] https://api.dotmailer.com/v2/contacts/{email}/transactional-data/{collectionName}	DELETE
[ ] https://api.dotmailer.com/v2/contacts/{email}/transactional-data/{collectionName}	GET
[x] https://api.dotmailer.com/v2/contacts/{id}	GET
[x] https://api.dotmailer.com/v2/contacts/{id}	PUT
[x] https://api.dotmailer.com/v2/contacts/{id}	DELETE
[ ] https://api.dotmailer.com/v2/contacts/{id}/transactional-data/{collectionName}	DELETE
[ ] https://api.dotmailer.com/v2/contacts/{id}/transactional-data/{collectionName}	GET
[x] https://api.dotmailer.com/v2/contacts/created-since/{date}?withFullData={withFullData}&select={select}&skip={skip}	GET
[ ] https://api.dotmailer.com/v2/contacts/import	POST
[ ] https://api.dotmailer.com/v2/contacts/import/{importId}	GET
[ ] https://api.dotmailer.com/v2/contacts/import/{importId}/report	GET
[ ] https://api.dotmailer.com/v2/contacts/import/{importId}/report-faults	GET
[x] https://api.dotmailer.com/v2/contacts/modified-since/{date}?withFullData={withFullData}&select={select}&skip={skip}	GET
[ ] https://api.dotmailer.com/v2/contacts/resubscribe	POST
[x] https://api.dotmailer.com/v2/contacts/suppressed-since/{date}?select={select}&skip={skip}	GET
[ ] https://api.dotmailer.com/v2/contacts/unsubscribe	POST
[x] https://api.dotmailer.com/v2/contacts/unsubscribed-since/{date}?select={select}&skip={skip}	GET
[x] https://api.dotmailer.com/v2/contacts?withFullData={withFullData}&select={select}&skip={skip}	GET
[ ] https://api.dotmailer.com/v2/custom-from-addresses?select={select}&skip={skip}	GET
[x] https://api.dotmailer.com/v2/data-fields	POST
[x] https://api.dotmailer.com/v2/data-fields	GET
[x] https://api.dotmailer.com/v2/data-fields/{name}	DELETE
[ ] https://api.dotmailer.com/v2/segments/refresh/{id}	POST
[ ] https://api.dotmailer.com/v2/segments/refresh/{id}	GET
[x] https://api.dotmailer.com/v2/segments?select={select}&skip={skip}	GET
[x] https://api.dotmailer.com/v2/templates	POST
[x] https://api.dotmailer.com/v2/templates/{id}	GET
[x] https://api.dotmailer.com/v2/templates/{id}	PUT 
[x] https://api.dotmailer.com/v2/templates?select={select}&skip={skip}	GET



[ ] https://api.dotmailer.com/v2/contacts/transactional-data/{collectionName}	POST
[ ] https://api.dotmailer.com/v2/contacts/transactional-data/{collectionName}/{key}	POST
[ ] https://api.dotmailer.com/v2/contacts/transactional-data/{collectionName}/{key}	DELETE
[ ] https://api.dotmailer.com/v2/contacts/transactional-data/{collectionName}/{key}	GET
[ ] https://api.dotmailer.com/v2/contacts/transactional-data/import/{collectionName}	POST
[ ] https://api.dotmailer.com/v2/contacts/transactional-data/import/{importId}	GET
[ ] https://api.dotmailer.com/v2/contacts/transactional-data/import/{importId}/report	GET
[ ] https://api.dotmailer.com/v2/document-folders	GET
[ ] https://api.dotmailer.com/v2/document-folders/{folderId}	POST
[ ] https://api.dotmailer.com/v2/document-folders/{folderId}/documents	GET
[ ] https://api.dotmailer.com/v2/document-folders/{folderId}/documents	POST
[ ] https://api.dotmailer.com/v2/image-folders	GET
[ ] https://api.dotmailer.com/v2/image-folders/{folderId}/images	POST
[ ] https://api.dotmailer.com/v2/image-folders/{id}	GET
[ ] https://api.dotmailer.com/v2/image-folders/{id}	POST
[ ] https://api.dotmailer.com/v2/server-time	GET
[ ] https://api.dotmailer.com/v2/sms-messages/send-to/{telephoneNumber}	POST