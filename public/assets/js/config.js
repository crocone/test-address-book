/* global $ */
const API_HOST = 'http://book.localhost/api';
const USER_ACCESS_TOKEN = $.session.get('access_token') ? $.session.get('access_token') : null;
const API_GET_CONTACTS = `${API_HOST}/contacts?access-token=${USER_ACCESS_TOKEN}`;
const API_GET_CONTACT = `${API_HOST}/contact?access-token=${USER_ACCESS_TOKEN}`;
const API_GET_CONTACT_TEMPLATE = `${API_HOST}/getContact?access-token=${USER_ACCESS_TOKEN}`;
const API_ADD_CONTACT = `${API_HOST}/addContact?access-token=${USER_ACCESS_TOKEN}`;
const API_UPDATE_CONTACT = `${API_HOST}/updateContact?access-token=${USER_ACCESS_TOKEN}`;
const API_GET_PROFILE_TEMPLATE = `${API_HOST}/getProfile?access-token=${USER_ACCESS_TOKEN}`;
const API_UPDATE_PROFILE = `${API_HOST}/updateProfile?access-token=${USER_ACCESS_TOKEN}`;
const API_GET_USERS = `${API_HOST}/getUsers?access-token=${USER_ACCESS_TOKEN}`;
