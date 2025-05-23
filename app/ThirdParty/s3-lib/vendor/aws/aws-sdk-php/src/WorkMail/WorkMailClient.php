<?php
namespace Aws\WorkMail;

use Aws\AwsClient;

/**
 * This client is used to interact with the **Amazon WorkMail** service.
 * @method \Aws\Result associateDelegateToResource(array $args = [])
 * @method \GuzzleHttp\Promise\Promise associateDelegateToResourceAsync(array $args = [])
 * @method \Aws\Result associateMemberToGroup(array $args = [])
 * @method \GuzzleHttp\Promise\Promise associateMemberToGroupAsync(array $args = [])
 * @method \Aws\Result cancelMailboxExportJob(array $args = [])
 * @method \GuzzleHttp\Promise\Promise cancelMailboxExportJobAsync(array $args = [])
 * @method \Aws\Result createAlias(array $args = [])
 * @method \GuzzleHttp\Promise\Promise createAliasAsync(array $args = [])
 * @method \Aws\Result createAvailabilityConfiguration(array $args = [])
 * @method \GuzzleHttp\Promise\Promise createAvailabilityConfigurationAsync(array $args = [])
 * @method \Aws\Result createGroup(array $args = [])
 * @method \GuzzleHttp\Promise\Promise createGroupAsync(array $args = [])
 * @method \Aws\Result createMobileDeviceAccessRule(array $args = [])
 * @method \GuzzleHttp\Promise\Promise createMobileDeviceAccessRuleAsync(array $args = [])
 * @method \Aws\Result createOrganization(array $args = [])
 * @method \GuzzleHttp\Promise\Promise createOrganizationAsync(array $args = [])
 * @method \Aws\Result createResource(array $args = [])
 * @method \GuzzleHttp\Promise\Promise createResourceAsync(array $args = [])
 * @method \Aws\Result createUser(array $args = [])
 * @method \GuzzleHttp\Promise\Promise createUserAsync(array $args = [])
 * @method \Aws\Result deleteAccessControlRule(array $args = [])
 * @method \GuzzleHttp\Promise\Promise deleteAccessControlRuleAsync(array $args = [])
 * @method \Aws\Result deleteAlias(array $args = [])
 * @method \GuzzleHttp\Promise\Promise deleteAliasAsync(array $args = [])
 * @method \Aws\Result deleteAvailabilityConfiguration(array $args = [])
 * @method \GuzzleHttp\Promise\Promise deleteAvailabilityConfigurationAsync(array $args = [])
 * @method \Aws\Result deleteEmailMonitoringConfiguration(array $args = [])
 * @method \GuzzleHttp\Promise\Promise deleteEmailMonitoringConfigurationAsync(array $args = [])
 * @method \Aws\Result deleteGroup(array $args = [])
 * @method \GuzzleHttp\Promise\Promise deleteGroupAsync(array $args = [])
 * @method \Aws\Result deleteMailboxPermissions(array $args = [])
 * @method \GuzzleHttp\Promise\Promise deleteMailboxPermissionsAsync(array $args = [])
 * @method \Aws\Result deleteMobileDeviceAccessOverride(array $args = [])
 * @method \GuzzleHttp\Promise\Promise deleteMobileDeviceAccessOverrideAsync(array $args = [])
 * @method \Aws\Result deleteMobileDeviceAccessRule(array $args = [])
 * @method \GuzzleHttp\Promise\Promise deleteMobileDeviceAccessRuleAsync(array $args = [])
 * @method \Aws\Result deleteOrganization(array $args = [])
 * @method \GuzzleHttp\Promise\Promise deleteOrganizationAsync(array $args = [])
 * @method \Aws\Result deleteResource(array $args = [])
 * @method \GuzzleHttp\Promise\Promise deleteResourceAsync(array $args = [])
 * @method \Aws\Result deleteRetentionPolicy(array $args = [])
 * @method \GuzzleHttp\Promise\Promise deleteRetentionPolicyAsync(array $args = [])
 * @method \Aws\Result deleteUser(array $args = [])
 * @method \GuzzleHttp\Promise\Promise deleteUserAsync(array $args = [])
 * @method \Aws\Result deregisterFromWorkMail(array $args = [])
 * @method \GuzzleHttp\Promise\Promise deregisterFromWorkMailAsync(array $args = [])
 * @method \Aws\Result deregisterMailDomain(array $args = [])
 * @method \GuzzleHttp\Promise\Promise deregisterMailDomainAsync(array $args = [])
 * @method \Aws\Result describeEmailMonitoringConfiguration(array $args = [])
 * @method \GuzzleHttp\Promise\Promise describeEmailMonitoringConfigurationAsync(array $args = [])
 * @method \Aws\Result describeGroup(array $args = [])
 * @method \GuzzleHttp\Promise\Promise describeGroupAsync(array $args = [])
 * @method \Aws\Result describeInboundDmarcSettings(array $args = [])
 * @method \GuzzleHttp\Promise\Promise describeInboundDmarcSettingsAsync(array $args = [])
 * @method \Aws\Result describeMailboxExportJob(array $args = [])
 * @method \GuzzleHttp\Promise\Promise describeMailboxExportJobAsync(array $args = [])
 * @method \Aws\Result describeOrganization(array $args = [])
 * @method \GuzzleHttp\Promise\Promise describeOrganizationAsync(array $args = [])
 * @method \Aws\Result describeResource(array $args = [])
 * @method \GuzzleHttp\Promise\Promise describeResourceAsync(array $args = [])
 * @method \Aws\Result describeUser(array $args = [])
 * @method \GuzzleHttp\Promise\Promise describeUserAsync(array $args = [])
 * @method \Aws\Result disassociateDelegateFromResource(array $args = [])
 * @method \GuzzleHttp\Promise\Promise disassociateDelegateFromResourceAsync(array $args = [])
 * @method \Aws\Result disassociateMemberFromGroup(array $args = [])
 * @method \GuzzleHttp\Promise\Promise disassociateMemberFromGroupAsync(array $args = [])
 * @method \Aws\Result getAccessControlEffect(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getAccessControlEffectAsync(array $args = [])
 * @method \Aws\Result getDefaultRetentionPolicy(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getDefaultRetentionPolicyAsync(array $args = [])
 * @method \Aws\Result getMailDomain(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getMailDomainAsync(array $args = [])
 * @method \Aws\Result getMailboxDetails(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getMailboxDetailsAsync(array $args = [])
 * @method \Aws\Result getMobileDeviceAccessEffect(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getMobileDeviceAccessEffectAsync(array $args = [])
 * @method \Aws\Result getMobileDeviceAccessOverride(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getMobileDeviceAccessOverrideAsync(array $args = [])
 * @method \Aws\Result listAccessControlRules(array $args = [])
 * @method \GuzzleHttp\Promise\Promise listAccessControlRulesAsync(array $args = [])
 * @method \Aws\Result listAliases(array $args = [])
 * @method \GuzzleHttp\Promise\Promise listAliasesAsync(array $args = [])
 * @method \Aws\Result listAvailabilityConfigurations(array $args = [])
 * @method \GuzzleHttp\Promise\Promise listAvailabilityConfigurationsAsync(array $args = [])
 * @method \Aws\Result listGroupMembers(array $args = [])
 * @method \GuzzleHttp\Promise\Promise listGroupMembersAsync(array $args = [])
 * @method \Aws\Result listGroups(array $args = [])
 * @method \GuzzleHttp\Promise\Promise listGroupsAsync(array $args = [])
 * @method \Aws\Result listMailDomains(array $args = [])
 * @method \GuzzleHttp\Promise\Promise listMailDomainsAsync(array $args = [])
 * @method \Aws\Result listMailboxExportJobs(array $args = [])
 * @method \GuzzleHttp\Promise\Promise listMailboxExportJobsAsync(array $args = [])
 * @method \Aws\Result listMailboxPermissions(array $args = [])
 * @method \GuzzleHttp\Promise\Promise listMailboxPermissionsAsync(array $args = [])
 * @method \Aws\Result listMobileDeviceAccessOverrides(array $args = [])
 * @method \GuzzleHttp\Promise\Promise listMobileDeviceAccessOverridesAsync(array $args = [])
 * @method \Aws\Result listMobileDeviceAccessRules(array $args = [])
 * @method \GuzzleHttp\Promise\Promise listMobileDeviceAccessRulesAsync(array $args = [])
 * @method \Aws\Result listOrganizations(array $args = [])
 * @method \GuzzleHttp\Promise\Promise listOrganizationsAsync(array $args = [])
 * @method \Aws\Result listResourceDelegates(array $args = [])
 * @method \GuzzleHttp\Promise\Promise listResourceDelegatesAsync(array $args = [])
 * @method \Aws\Result listResources(array $args = [])
 * @method \GuzzleHttp\Promise\Promise listResourcesAsync(array $args = [])
 * @method \Aws\Result listTagsForResource(array $args = [])
 * @method \GuzzleHttp\Promise\Promise listTagsForResourceAsync(array $args = [])
 * @method \Aws\Result listUsers(array $args = [])
 * @method \GuzzleHttp\Promise\Promise listUsersAsync(array $args = [])
 * @method \Aws\Result putAccessControlRule(array $args = [])
 * @method \GuzzleHttp\Promise\Promise putAccessControlRuleAsync(array $args = [])
 * @method \Aws\Result putEmailMonitoringConfiguration(array $args = [])
 * @method \GuzzleHttp\Promise\Promise putEmailMonitoringConfigurationAsync(array $args = [])
 * @method \Aws\Result putInboundDmarcSettings(array $args = [])
 * @method \GuzzleHttp\Promise\Promise putInboundDmarcSettingsAsync(array $args = [])
 * @method \Aws\Result putMailboxPermissions(array $args = [])
 * @method \GuzzleHttp\Promise\Promise putMailboxPermissionsAsync(array $args = [])
 * @method \Aws\Result putMobileDeviceAccessOverride(array $args = [])
 * @method \GuzzleHttp\Promise\Promise putMobileDeviceAccessOverrideAsync(array $args = [])
 * @method \Aws\Result putRetentionPolicy(array $args = [])
 * @method \GuzzleHttp\Promise\Promise putRetentionPolicyAsync(array $args = [])
 * @method \Aws\Result registerMailDomain(array $args = [])
 * @method \GuzzleHttp\Promise\Promise registerMailDomainAsync(array $args = [])
 * @method \Aws\Result registerToWorkMail(array $args = [])
 * @method \GuzzleHttp\Promise\Promise registerToWorkMailAsync(array $args = [])
 * @method \Aws\Result resetPassword(array $args = [])
 * @method \GuzzleHttp\Promise\Promise resetPasswordAsync(array $args = [])
 * @method \Aws\Result startMailboxExportJob(array $args = [])
 * @method \GuzzleHttp\Promise\Promise startMailboxExportJobAsync(array $args = [])
 * @method \Aws\Result tagResource(array $args = [])
 * @method \GuzzleHttp\Promise\Promise tagResourceAsync(array $args = [])
 * @method \Aws\Result testAvailabilityConfiguration(array $args = [])
 * @method \GuzzleHttp\Promise\Promise testAvailabilityConfigurationAsync(array $args = [])
 * @method \Aws\Result untagResource(array $args = [])
 * @method \GuzzleHttp\Promise\Promise untagResourceAsync(array $args = [])
 * @method \Aws\Result updateAvailabilityConfiguration(array $args = [])
 * @method \GuzzleHttp\Promise\Promise updateAvailabilityConfigurationAsync(array $args = [])
 * @method \Aws\Result updateDefaultMailDomain(array $args = [])
 * @method \GuzzleHttp\Promise\Promise updateDefaultMailDomainAsync(array $args = [])
 * @method \Aws\Result updateMailboxQuota(array $args = [])
 * @method \GuzzleHttp\Promise\Promise updateMailboxQuotaAsync(array $args = [])
 * @method \Aws\Result updateMobileDeviceAccessRule(array $args = [])
 * @method \GuzzleHttp\Promise\Promise updateMobileDeviceAccessRuleAsync(array $args = [])
 * @method \Aws\Result updatePrimaryEmailAddress(array $args = [])
 * @method \GuzzleHttp\Promise\Promise updatePrimaryEmailAddressAsync(array $args = [])
 * @method \Aws\Result updateResource(array $args = [])
 * @method \GuzzleHttp\Promise\Promise updateResourceAsync(array $args = [])
 */
class WorkMailClient extends AwsClient {}
