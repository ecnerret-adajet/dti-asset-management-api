# DAELIFT SYSTEM - USER ACCEPTANCE TESTING (UAT) TEMPLATE

**Project Name:** DAELIFT System Enhancement and Feature Implementation  
**UAT Document Version:** 1.0  
**Date:** September 26, 2025  
**Testing Period:** [Start Date] to [End Date]  
**UAT Lead:** [Name]  
**Business Users:** [Names]  

---

## UAT OVERVIEW

### Purpose
This User Acceptance Testing template validates that all implemented DAELIFT system features meet business requirements and function correctly in a production-like environment.

### Testing Scope
- Permission System Implementation
- Inventory Module Enhancements
- Orders Module Updates
- Requests Module Improvements
- Accounts Module Features
- Reports Module Implementation

### Test Result Legend
- ✅ **PASS** - Feature works as expected
- ❌ **FAIL** - Feature does not work as expected
- ⚠️ **PARTIAL** - Feature partially works, needs minor adjustments
- 🔄 **RETEST** - Feature needs to be retested after fixes

---

## 1. PERMISSION SYSTEM TESTING

### 1.1 Core Asset and User Permissions

| Test ID | Permission | Test Description | Expected Result | Actual Result | Status | Tester | Notes |
|---------|------------|------------------|-----------------|---------------|---------|---------|-------|
| UAT-P001 | Read | Login as user with Read permission, view asset details | Can view all asset information without edit options | | | | |
| UAT-P002 | Create | Login as user with Create permission, add new asset | Can successfully create new asset with all required fields | | | | |
| UAT-P003 | Update | Login as user with Update permission, modify existing asset | Can edit and save changes to existing asset details | | | | |
| UAT-P004 | Delete | Login as user with Delete permission, remove asset | Can delete asset with proper confirmation prompt | | | | |
| UAT-P005 | Show User | Login as user with Show User permission, view user details | Can access and view other users' information | | | | |
| UAT-P006 | Settings | Login as admin, access system settings | Can access and modify system configuration | | | | |
| UAT-P007 | View Users | Access user management section | Can view list of all system users | | | | |
| UAT-P008 | View Customers | Access customer management section | Can view complete customer list | | | | |
| UAT-P009 | View Suppliers | Access supplier management section | Can view complete supplier list | | | | |
| UAT-P010 | Create Supplier | Add new supplier to system | Can successfully create new supplier record | | | | |
| UAT-P011 | Create Asset Type | Add new asset type | Can create new asset type and use in asset creation | | | | |
| UAT-P012 | Create Location | Add new location | Can create new location and assign to assets | | | | |
| UAT-P013 | Create Customer | Add new customer | Can successfully create new customer record | | | | |

### 1.2 Order Management Permissions

| Test ID | Permission | Test Description | Expected Result | Actual Result | Status | Tester | Notes |
|---------|------------|------------------|-----------------|---------------|---------|---------|-------|
| UAT-P014 | Orders-Show | View existing orders | Can access and view all customer orders | | | | |
| UAT-P015 | Orders-Create | Create new customer order | Can successfully create new order with all details | | | | |
| UAT-P016 | Orders-Delete | Delete customer order | Can remove order with proper confirmation | | | | |
| UAT-P017 | Order-Details-Edit | Edit order details | Can modify customer name, order ID, quantity, and price | | | | |

### 1.3 Request Management Permissions

| Test ID | Permission | Test Description | Expected Result | Actual Result | Status | Tester | Notes |
|---------|------------|------------------|-----------------|---------------|---------|---------|-------|
| UAT-P018 | Request-Show | View asset requests | Can view all existing asset/part order requests | | | | |
| UAT-P019 | Request-Create | Create asset request via "add to inventory" | Can create new asset request using button | | | | |
| UAT-P020 | Request-Update | Update existing request | Can modify existing asset order requests | | | | |
| UAT-P021 | Request-Delete | Delete asset request | Can remove requests with proper confirmation | | | | |
| UAT-P022 | Add to Inventory | Request assets for inventory | Can successfully request assets for inventory | | | | |

### 1.4 Advanced User and Role Management

| Test ID | Permission | Test Description | Expected Result | Actual Result | Status | Tester | Notes |
|---------|------------|------------------|-----------------|---------------|---------|---------|-------|
| UAT-P023 | Customer-Detail-edit | Edit customer information | Can modify customer details and save changes | | | | |
| UAT-P024 | new-user | Create new system user | Can create new user with role assignment | | | | |
| UAT-P025 | view-permissions | View permission documentation | Can see list of all available permissions | | | | |
| UAT-P026 | view-roles | View role assignments | Can see roles and their assigned permissions | | | | |
| UAT-P027 | edit-roles | Modify role permissions | Can change permissions assigned to roles | | | | |
| UAT-P028 | add-roles | Create new role | Can create new role and assign permissions | | | | |
| UAT-P029 | edit-customer | Edit customer details | Can modify customer information | | | | |
| UAT-P030 | edit-supplier | Edit supplier details | Can modify supplier information | | | | |
| UAT-P031 | delete-customer | Soft delete customer | Customer is hidden but data preserved | | | | |
| UAT-P032 | delete-supplier | Soft delete supplier | Supplier is hidden but data preserved | | | | |
| UAT-P033 | user-list | Admin access to user list | Only admin can access user management | | | | |

---

## 2. INVENTORY MODULE TESTING

| Test ID | Feature | Test Description | Expected Result | Actual Result | Status | Tester | Notes |
|---------|---------|------------------|-----------------|---------------|---------|---------|-------|
| UAT-I001 | Clickable Asset Pictures | Click on asset image in inventory list | Image opens in separate pop-up window | | | | |
| UAT-I002 | Image Zoom Controls | Use zoom controls in image pop-up | Can zoom in and out of image | | | | |
| UAT-I003 | Window Close Function | Close image pop-up window | Returns to inventory interface | | | | |
| UAT-I004 | Asset Model Search | Search for assets by model | Search returns matching assets by model | | | | |
| UAT-I005 | Serial Number Display | View inventory list | Serial number column is visible and populated | | | | |
| UAT-I006 | Location Sorting | Sort assets by location | Assets are properly sorted by location | | | | |
| UAT-I007 | Remove Status Sorting | Check sorting options | Status, type, quantity sorting options removed | | | | |
| UAT-I008 | Clickable Images in Edit | Edit asset and click image | Image opens in pop-up from edit mode | | | | |
| UAT-I009 | Asset Details Popup | Click on asset name | Details appear in popup modal, not new page | | | | |
| UAT-I010 | Popup Content | Review popup content | Shows name, description, location, model, serial, part number, supplier, quantity | | | | |

---

## 3. ORDERS MODULE TESTING

| Test ID | Feature | Test Description | Expected Result | Actual Result | Status | Tester | Notes |
|---------|---------|------------------|-----------------|---------------|---------|---------|-------|
| UAT-O001 | Add Customer Option | Create order with new customer | Option to add new customer during order creation | | | | |
| UAT-O002 | Customer Database Integration | Add new customer during order | New customer automatically saved to database | | | | |
| UAT-O003 | Serial Number in Orders | View order details | Serial numbers displayed in ordered items | | | | |
| UAT-O004 | Part Number in Orders | View order confirmation | Part numbers shown in order confirmation | | | | |
| UAT-O005 | Order Details Modal | Click order details | Details open in modal window | | | | |
| UAT-O006 | Functional Status Button | Use order status button | Status button changes order status | | | | |
| UAT-O007 | Status-Based Edit Control | Try editing delivered order | Order details are read-only when delivered/failed | | | | |
| UAT-O008 | In-Transit Status Control | Update in-transit order | Can only change to delivered or failed | | | | |
| UAT-O009 | View-Only for Completed | Access completed orders | Delivered/failed orders are view-only | | | | |
| UAT-O010 | Editable Order ID | Edit order ID | Can modify order ID for PO matching | | | | |
| UAT-O011 | Order Details Editing | Edit order details | Can modify customer name, price, order ID, quantity | | | | |
| UAT-O012 | Inventory Deduction | Change order to delivered | Asset quantity decreases only on delivered status | | | | |
| UAT-O013 | Delivery Trigger | Mark order as delivered | Inventory automatically updated | | | | |

---

## 4. REQUESTS MODULE TESTING

| Test ID | Feature | Test Description | Expected Result | Actual Result | Status | Tester | Notes |
|---------|---------|------------------|-----------------|---------------|---------|---------|-------|
| UAT-R001 | Reference Number | Create new asset request | Field shows "Reference Number" instead of "PO Number" | | | | |
| UAT-R002 | Status Lock | Try changing cancelled request | Cannot change status of cancelled/added requests | | | | |
| UAT-R003 | Serial Number Display | View asset requests | Serial and part numbers visible in request interface | | | | |
| UAT-R004 | Part Number in Receivings | Check receivings section | Part number and serial shown under asset name | | | | |
| UAT-R005 | Optional Reference Number | Create request without reference | Reference number field is optional | | | | |
| UAT-R006 | Remarks Display | View request details | Remarks from receivings are displayed | | | | |

---

## 5. ACCOUNTS MODULE TESTING

| Test ID | Feature | Test Description | Expected Result | Actual Result | Status | Tester | Notes |
|---------|---------|------------------|-----------------|---------------|---------|---------|-------|
| UAT-A001 | Customer Edit Function | Edit customer information | Can modify and save customer details | | | | |
| UAT-A002 | Supplier Edit Function | Edit supplier information | Can modify and save supplier details | | | | |
| UAT-A003 | Customer Soft Delete | Delete customer | Customer hidden but data preserved | | | | |
| UAT-A004 | Supplier Soft Delete | Delete supplier | Supplier hidden but data preserved | | | | |
| UAT-A005 | Admin User List Access | Login as non-admin | Cannot access user management list | | | | |
| UAT-A006 | User Self-Update | Edit own account | Can modify own account information | | | | |
| UAT-A007 | Prevent User Cross-Update | Try editing other user | Cannot modify other users' accounts | | | | |
| UAT-A008 | Admin Role Update | Login as admin | Can update user roles | | | | |

---

## 6. REPORTS MODULE TESTING

| Test ID | Feature | Test Description | Expected Result | Actual Result | Status | Tester | Notes |
|---------|---------|------------------|-----------------|---------------|---------|---------|-------|
| UAT-R001 | Inventory Alerts | Set low inventory threshold | System generates alerts for low stock | | | | |
| UAT-R002 | Alert Notifications | Trigger inventory alert | Notifications sent when thresholds reached | | | | |
| UAT-R003 | Inventory Summary | Generate inventory report | Shows in/out summary for selected date range | | | | |
| UAT-R004 | Daily Reports | Run daily report | Displays daily inventory movements | | | | |
| UAT-R005 | Date Range Selection | Select custom date range | Reports generate for specified period | | | | |
| UAT-R006 | Data Backup | Initiate backup | Data backup completes successfully | | | | |

---

## 7. INTEGRATION TESTING

| Test ID | Integration Area | Test Description | Expected Result | Actual Result | Status | Tester | Notes |
|---------|------------------|------------------|-----------------|---------------|---------|---------|-------|
| UAT-I001 | Order-Inventory Integration | Create and deliver order | Inventory automatically updated when delivered | | | | |
| UAT-I002 | Request-Inventory Integration | Complete asset request | Asset added to inventory when request completed | | | | |
| UAT-I003 | User-Permission Integration | Change user role | User permissions immediately updated | | | | |
| UAT-I004 | Customer-Order Integration | Add customer during order | New customer available in all modules | | | | |
| UAT-I005 | Supplier-Asset Integration | Create asset with supplier | Supplier information properly linked | | | | |

---

## 8. CROSS-BROWSER TESTING

| Test ID | Browser | Test Description | Expected Result | Actual Result | Status | Tester | Notes |
|---------|---------|------------------|-----------------|---------------|---------|---------|-------|
| UAT-B001 | Chrome | Full system functionality | All features work correctly | | | | |
| UAT-B002 | Firefox | Full system functionality | All features work correctly | | | | |
| UAT-B003 | Safari | Full system functionality | All features work correctly | | | | |
| UAT-B004 | Edge | Full system functionality | All features work correctly | | | | |

---

## 9. PERFORMANCE TESTING

| Test ID | Performance Area | Test Description | Expected Result | Actual Result | Status | Tester | Notes |
|---------|------------------|------------------|-----------------|---------------|---------|---------|-------|
| UAT-PF001 | Page Load Time | Load inventory page with 1000+ assets | Page loads within 3 seconds | | | | |
| UAT-PF002 | Search Performance | Search across large dataset | Results returned within 2 seconds | | | | |
| UAT-PF003 | Report Generation | Generate large inventory report | Report completes within 30 seconds | | | | |
| UAT-PF004 | Image Loading | Load asset images | Images load within 2 seconds | | | | |

---

## 10. SECURITY TESTING

| Test ID | Security Area | Test Description | Expected Result | Actual Result | Status | Tester | Notes |
|---------|---------------|------------------|-----------------|---------------|---------|---------|-------|
| UAT-S001 | Permission Enforcement | Access restricted feature | Access denied for unauthorized users | | | | |
| UAT-S002 | Session Management | Idle timeout testing | Session expires after configured time | | | | |
| UAT-S003 | Data Validation | Input malicious data | System rejects invalid/malicious input | | | | |
| UAT-S004 | SQL Injection | Test input fields | System prevents SQL injection attacks | | | | |

---

## UAT SIGN-OFF

### Test Summary

| Module | Total Tests | Passed | Failed | Partial | Retest Required |
|--------|-------------|--------|--------|---------|-----------------|
| Permissions | 33 | | | | |
| Inventory | 10 | | | | |
| Orders | 13 | | | | |
| Requests | 6 | | | | |
| Accounts | 8 | | | | |
| Reports | 6 | | | | |
| Integration | 5 | | | | |
| Browser | 4 | | | | |
| Performance | 4 | | | | |
| Security | 4 | | | | |
| **TOTAL** | **93** | | | | |

### Final UAT Result: [ ] PASS [ ] FAIL [ ] CONDITIONAL PASS

### Issues Summary
| Severity | Count | Status |
|----------|-------|--------|
| Critical | | |
| High | | |
| Medium | | |
| Low | | |

### UAT Approval

**Business User Sign-off:**
- Name: _________________ Signature: _________________ Date: _________
- Name: _________________ Signature: _________________ Date: _________

**IT/Development Team Sign-off:**
- Name: _________________ Signature: _________________ Date: _________

**Project Manager Sign-off:**
- Name: _________________ Signature: _________________ Date: _________

### Comments/Recommendations:
_________________________________________________
_________________________________________________
_________________________________________________

---

**Next Steps After UAT:**
1. [ ] Production Deployment Planning
2. [ ] User Training Schedule
3. [ ] Go-Live Support Plan
4. [ ] Post-Implementation Review Schedule