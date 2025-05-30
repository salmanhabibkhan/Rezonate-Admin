<?php
namespace Aws\Glue;

use Aws\AwsClient;

/**
 * This client is used to interact with the **AWS Glue** service.
 * @method \Aws\Result batchCreatePartition(array $args = [])
 * @method \GuzzleHttp\Promise\Promise batchCreatePartitionAsync(array $args = [])
 * @method \Aws\Result batchDeleteConnection(array $args = [])
 * @method \GuzzleHttp\Promise\Promise batchDeleteConnectionAsync(array $args = [])
 * @method \Aws\Result batchDeletePartition(array $args = [])
 * @method \GuzzleHttp\Promise\Promise batchDeletePartitionAsync(array $args = [])
 * @method \Aws\Result batchDeleteTable(array $args = [])
 * @method \GuzzleHttp\Promise\Promise batchDeleteTableAsync(array $args = [])
 * @method \Aws\Result batchDeleteTableVersion(array $args = [])
 * @method \GuzzleHttp\Promise\Promise batchDeleteTableVersionAsync(array $args = [])
 * @method \Aws\Result batchGetBlueprints(array $args = [])
 * @method \GuzzleHttp\Promise\Promise batchGetBlueprintsAsync(array $args = [])
 * @method \Aws\Result batchGetCrawlers(array $args = [])
 * @method \GuzzleHttp\Promise\Promise batchGetCrawlersAsync(array $args = [])
 * @method \Aws\Result batchGetCustomEntityTypes(array $args = [])
 * @method \GuzzleHttp\Promise\Promise batchGetCustomEntityTypesAsync(array $args = [])
 * @method \Aws\Result batchGetDevEndpoints(array $args = [])
 * @method \GuzzleHttp\Promise\Promise batchGetDevEndpointsAsync(array $args = [])
 * @method \Aws\Result batchGetJobs(array $args = [])
 * @method \GuzzleHttp\Promise\Promise batchGetJobsAsync(array $args = [])
 * @method \Aws\Result batchGetPartition(array $args = [])
 * @method \GuzzleHttp\Promise\Promise batchGetPartitionAsync(array $args = [])
 * @method \Aws\Result batchGetTriggers(array $args = [])
 * @method \GuzzleHttp\Promise\Promise batchGetTriggersAsync(array $args = [])
 * @method \Aws\Result batchGetWorkflows(array $args = [])
 * @method \GuzzleHttp\Promise\Promise batchGetWorkflowsAsync(array $args = [])
 * @method \Aws\Result batchStopJobRun(array $args = [])
 * @method \GuzzleHttp\Promise\Promise batchStopJobRunAsync(array $args = [])
 * @method \Aws\Result batchUpdatePartition(array $args = [])
 * @method \GuzzleHttp\Promise\Promise batchUpdatePartitionAsync(array $args = [])
 * @method \Aws\Result cancelMLTaskRun(array $args = [])
 * @method \GuzzleHttp\Promise\Promise cancelMLTaskRunAsync(array $args = [])
 * @method \Aws\Result cancelStatement(array $args = [])
 * @method \GuzzleHttp\Promise\Promise cancelStatementAsync(array $args = [])
 * @method \Aws\Result checkSchemaVersionValidity(array $args = [])
 * @method \GuzzleHttp\Promise\Promise checkSchemaVersionValidityAsync(array $args = [])
 * @method \Aws\Result createBlueprint(array $args = [])
 * @method \GuzzleHttp\Promise\Promise createBlueprintAsync(array $args = [])
 * @method \Aws\Result createClassifier(array $args = [])
 * @method \GuzzleHttp\Promise\Promise createClassifierAsync(array $args = [])
 * @method \Aws\Result createConnection(array $args = [])
 * @method \GuzzleHttp\Promise\Promise createConnectionAsync(array $args = [])
 * @method \Aws\Result createCrawler(array $args = [])
 * @method \GuzzleHttp\Promise\Promise createCrawlerAsync(array $args = [])
 * @method \Aws\Result createCustomEntityType(array $args = [])
 * @method \GuzzleHttp\Promise\Promise createCustomEntityTypeAsync(array $args = [])
 * @method \Aws\Result createDatabase(array $args = [])
 * @method \GuzzleHttp\Promise\Promise createDatabaseAsync(array $args = [])
 * @method \Aws\Result createDevEndpoint(array $args = [])
 * @method \GuzzleHttp\Promise\Promise createDevEndpointAsync(array $args = [])
 * @method \Aws\Result createJob(array $args = [])
 * @method \GuzzleHttp\Promise\Promise createJobAsync(array $args = [])
 * @method \Aws\Result createMLTransform(array $args = [])
 * @method \GuzzleHttp\Promise\Promise createMLTransformAsync(array $args = [])
 * @method \Aws\Result createPartition(array $args = [])
 * @method \GuzzleHttp\Promise\Promise createPartitionAsync(array $args = [])
 * @method \Aws\Result createPartitionIndex(array $args = [])
 * @method \GuzzleHttp\Promise\Promise createPartitionIndexAsync(array $args = [])
 * @method \Aws\Result createRegistry(array $args = [])
 * @method \GuzzleHttp\Promise\Promise createRegistryAsync(array $args = [])
 * @method \Aws\Result createSchema(array $args = [])
 * @method \GuzzleHttp\Promise\Promise createSchemaAsync(array $args = [])
 * @method \Aws\Result createScript(array $args = [])
 * @method \GuzzleHttp\Promise\Promise createScriptAsync(array $args = [])
 * @method \Aws\Result createSecurityConfiguration(array $args = [])
 * @method \GuzzleHttp\Promise\Promise createSecurityConfigurationAsync(array $args = [])
 * @method \Aws\Result createSession(array $args = [])
 * @method \GuzzleHttp\Promise\Promise createSessionAsync(array $args = [])
 * @method \Aws\Result createTable(array $args = [])
 * @method \GuzzleHttp\Promise\Promise createTableAsync(array $args = [])
 * @method \Aws\Result createTrigger(array $args = [])
 * @method \GuzzleHttp\Promise\Promise createTriggerAsync(array $args = [])
 * @method \Aws\Result createUserDefinedFunction(array $args = [])
 * @method \GuzzleHttp\Promise\Promise createUserDefinedFunctionAsync(array $args = [])
 * @method \Aws\Result createWorkflow(array $args = [])
 * @method \GuzzleHttp\Promise\Promise createWorkflowAsync(array $args = [])
 * @method \Aws\Result deleteBlueprint(array $args = [])
 * @method \GuzzleHttp\Promise\Promise deleteBlueprintAsync(array $args = [])
 * @method \Aws\Result deleteClassifier(array $args = [])
 * @method \GuzzleHttp\Promise\Promise deleteClassifierAsync(array $args = [])
 * @method \Aws\Result deleteColumnStatisticsForPartition(array $args = [])
 * @method \GuzzleHttp\Promise\Promise deleteColumnStatisticsForPartitionAsync(array $args = [])
 * @method \Aws\Result deleteColumnStatisticsForTable(array $args = [])
 * @method \GuzzleHttp\Promise\Promise deleteColumnStatisticsForTableAsync(array $args = [])
 * @method \Aws\Result deleteConnection(array $args = [])
 * @method \GuzzleHttp\Promise\Promise deleteConnectionAsync(array $args = [])
 * @method \Aws\Result deleteCrawler(array $args = [])
 * @method \GuzzleHttp\Promise\Promise deleteCrawlerAsync(array $args = [])
 * @method \Aws\Result deleteCustomEntityType(array $args = [])
 * @method \GuzzleHttp\Promise\Promise deleteCustomEntityTypeAsync(array $args = [])
 * @method \Aws\Result deleteDatabase(array $args = [])
 * @method \GuzzleHttp\Promise\Promise deleteDatabaseAsync(array $args = [])
 * @method \Aws\Result deleteDevEndpoint(array $args = [])
 * @method \GuzzleHttp\Promise\Promise deleteDevEndpointAsync(array $args = [])
 * @method \Aws\Result deleteJob(array $args = [])
 * @method \GuzzleHttp\Promise\Promise deleteJobAsync(array $args = [])
 * @method \Aws\Result deleteMLTransform(array $args = [])
 * @method \GuzzleHttp\Promise\Promise deleteMLTransformAsync(array $args = [])
 * @method \Aws\Result deletePartition(array $args = [])
 * @method \GuzzleHttp\Promise\Promise deletePartitionAsync(array $args = [])
 * @method \Aws\Result deletePartitionIndex(array $args = [])
 * @method \GuzzleHttp\Promise\Promise deletePartitionIndexAsync(array $args = [])
 * @method \Aws\Result deleteRegistry(array $args = [])
 * @method \GuzzleHttp\Promise\Promise deleteRegistryAsync(array $args = [])
 * @method \Aws\Result deleteResourcePolicy(array $args = [])
 * @method \GuzzleHttp\Promise\Promise deleteResourcePolicyAsync(array $args = [])
 * @method \Aws\Result deleteSchema(array $args = [])
 * @method \GuzzleHttp\Promise\Promise deleteSchemaAsync(array $args = [])
 * @method \Aws\Result deleteSchemaVersions(array $args = [])
 * @method \GuzzleHttp\Promise\Promise deleteSchemaVersionsAsync(array $args = [])
 * @method \Aws\Result deleteSecurityConfiguration(array $args = [])
 * @method \GuzzleHttp\Promise\Promise deleteSecurityConfigurationAsync(array $args = [])
 * @method \Aws\Result deleteSession(array $args = [])
 * @method \GuzzleHttp\Promise\Promise deleteSessionAsync(array $args = [])
 * @method \Aws\Result deleteTable(array $args = [])
 * @method \GuzzleHttp\Promise\Promise deleteTableAsync(array $args = [])
 * @method \Aws\Result deleteTableVersion(array $args = [])
 * @method \GuzzleHttp\Promise\Promise deleteTableVersionAsync(array $args = [])
 * @method \Aws\Result deleteTrigger(array $args = [])
 * @method \GuzzleHttp\Promise\Promise deleteTriggerAsync(array $args = [])
 * @method \Aws\Result deleteUserDefinedFunction(array $args = [])
 * @method \GuzzleHttp\Promise\Promise deleteUserDefinedFunctionAsync(array $args = [])
 * @method \Aws\Result deleteWorkflow(array $args = [])
 * @method \GuzzleHttp\Promise\Promise deleteWorkflowAsync(array $args = [])
 * @method \Aws\Result getBlueprint(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getBlueprintAsync(array $args = [])
 * @method \Aws\Result getBlueprintRun(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getBlueprintRunAsync(array $args = [])
 * @method \Aws\Result getBlueprintRuns(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getBlueprintRunsAsync(array $args = [])
 * @method \Aws\Result getCatalogImportStatus(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getCatalogImportStatusAsync(array $args = [])
 * @method \Aws\Result getClassifier(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getClassifierAsync(array $args = [])
 * @method \Aws\Result getClassifiers(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getClassifiersAsync(array $args = [])
 * @method \Aws\Result getColumnStatisticsForPartition(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getColumnStatisticsForPartitionAsync(array $args = [])
 * @method \Aws\Result getColumnStatisticsForTable(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getColumnStatisticsForTableAsync(array $args = [])
 * @method \Aws\Result getConnection(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getConnectionAsync(array $args = [])
 * @method \Aws\Result getConnections(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getConnectionsAsync(array $args = [])
 * @method \Aws\Result getCrawler(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getCrawlerAsync(array $args = [])
 * @method \Aws\Result getCrawlerMetrics(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getCrawlerMetricsAsync(array $args = [])
 * @method \Aws\Result getCrawlers(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getCrawlersAsync(array $args = [])
 * @method \Aws\Result getCustomEntityType(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getCustomEntityTypeAsync(array $args = [])
 * @method \Aws\Result getDataCatalogEncryptionSettings(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getDataCatalogEncryptionSettingsAsync(array $args = [])
 * @method \Aws\Result getDatabase(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getDatabaseAsync(array $args = [])
 * @method \Aws\Result getDatabases(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getDatabasesAsync(array $args = [])
 * @method \Aws\Result getDataflowGraph(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getDataflowGraphAsync(array $args = [])
 * @method \Aws\Result getDevEndpoint(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getDevEndpointAsync(array $args = [])
 * @method \Aws\Result getDevEndpoints(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getDevEndpointsAsync(array $args = [])
 * @method \Aws\Result getJob(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getJobAsync(array $args = [])
 * @method \Aws\Result getJobBookmark(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getJobBookmarkAsync(array $args = [])
 * @method \Aws\Result getJobRun(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getJobRunAsync(array $args = [])
 * @method \Aws\Result getJobRuns(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getJobRunsAsync(array $args = [])
 * @method \Aws\Result getJobs(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getJobsAsync(array $args = [])
 * @method \Aws\Result getMLTaskRun(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getMLTaskRunAsync(array $args = [])
 * @method \Aws\Result getMLTaskRuns(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getMLTaskRunsAsync(array $args = [])
 * @method \Aws\Result getMLTransform(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getMLTransformAsync(array $args = [])
 * @method \Aws\Result getMLTransforms(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getMLTransformsAsync(array $args = [])
 * @method \Aws\Result getMapping(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getMappingAsync(array $args = [])
 * @method \Aws\Result getPartition(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getPartitionAsync(array $args = [])
 * @method \Aws\Result getPartitionIndexes(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getPartitionIndexesAsync(array $args = [])
 * @method \Aws\Result getPartitions(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getPartitionsAsync(array $args = [])
 * @method \Aws\Result getPlan(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getPlanAsync(array $args = [])
 * @method \Aws\Result getRegistry(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getRegistryAsync(array $args = [])
 * @method \Aws\Result getResourcePolicies(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getResourcePoliciesAsync(array $args = [])
 * @method \Aws\Result getResourcePolicy(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getResourcePolicyAsync(array $args = [])
 * @method \Aws\Result getSchema(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getSchemaAsync(array $args = [])
 * @method \Aws\Result getSchemaByDefinition(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getSchemaByDefinitionAsync(array $args = [])
 * @method \Aws\Result getSchemaVersion(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getSchemaVersionAsync(array $args = [])
 * @method \Aws\Result getSchemaVersionsDiff(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getSchemaVersionsDiffAsync(array $args = [])
 * @method \Aws\Result getSecurityConfiguration(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getSecurityConfigurationAsync(array $args = [])
 * @method \Aws\Result getSecurityConfigurations(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getSecurityConfigurationsAsync(array $args = [])
 * @method \Aws\Result getSession(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getSessionAsync(array $args = [])
 * @method \Aws\Result getStatement(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getStatementAsync(array $args = [])
 * @method \Aws\Result getTable(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getTableAsync(array $args = [])
 * @method \Aws\Result getTableVersion(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getTableVersionAsync(array $args = [])
 * @method \Aws\Result getTableVersions(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getTableVersionsAsync(array $args = [])
 * @method \Aws\Result getTables(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getTablesAsync(array $args = [])
 * @method \Aws\Result getTags(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getTagsAsync(array $args = [])
 * @method \Aws\Result getTrigger(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getTriggerAsync(array $args = [])
 * @method \Aws\Result getTriggers(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getTriggersAsync(array $args = [])
 * @method \Aws\Result getUnfilteredPartitionMetadata(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getUnfilteredPartitionMetadataAsync(array $args = [])
 * @method \Aws\Result getUnfilteredPartitionsMetadata(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getUnfilteredPartitionsMetadataAsync(array $args = [])
 * @method \Aws\Result getUnfilteredTableMetadata(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getUnfilteredTableMetadataAsync(array $args = [])
 * @method \Aws\Result getUserDefinedFunction(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getUserDefinedFunctionAsync(array $args = [])
 * @method \Aws\Result getUserDefinedFunctions(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getUserDefinedFunctionsAsync(array $args = [])
 * @method \Aws\Result getWorkflow(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getWorkflowAsync(array $args = [])
 * @method \Aws\Result getWorkflowRun(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getWorkflowRunAsync(array $args = [])
 * @method \Aws\Result getWorkflowRunProperties(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getWorkflowRunPropertiesAsync(array $args = [])
 * @method \Aws\Result getWorkflowRuns(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getWorkflowRunsAsync(array $args = [])
 * @method \Aws\Result importCatalogToGlue(array $args = [])
 * @method \GuzzleHttp\Promise\Promise importCatalogToGlueAsync(array $args = [])
 * @method \Aws\Result listBlueprints(array $args = [])
 * @method \GuzzleHttp\Promise\Promise listBlueprintsAsync(array $args = [])
 * @method \Aws\Result listCrawlers(array $args = [])
 * @method \GuzzleHttp\Promise\Promise listCrawlersAsync(array $args = [])
 * @method \Aws\Result listCrawls(array $args = [])
 * @method \GuzzleHttp\Promise\Promise listCrawlsAsync(array $args = [])
 * @method \Aws\Result listCustomEntityTypes(array $args = [])
 * @method \GuzzleHttp\Promise\Promise listCustomEntityTypesAsync(array $args = [])
 * @method \Aws\Result listDevEndpoints(array $args = [])
 * @method \GuzzleHttp\Promise\Promise listDevEndpointsAsync(array $args = [])
 * @method \Aws\Result listJobs(array $args = [])
 * @method \GuzzleHttp\Promise\Promise listJobsAsync(array $args = [])
 * @method \Aws\Result listMLTransforms(array $args = [])
 * @method \GuzzleHttp\Promise\Promise listMLTransformsAsync(array $args = [])
 * @method \Aws\Result listRegistries(array $args = [])
 * @method \GuzzleHttp\Promise\Promise listRegistriesAsync(array $args = [])
 * @method \Aws\Result listSchemaVersions(array $args = [])
 * @method \GuzzleHttp\Promise\Promise listSchemaVersionsAsync(array $args = [])
 * @method \Aws\Result listSchemas(array $args = [])
 * @method \GuzzleHttp\Promise\Promise listSchemasAsync(array $args = [])
 * @method \Aws\Result listSessions(array $args = [])
 * @method \GuzzleHttp\Promise\Promise listSessionsAsync(array $args = [])
 * @method \Aws\Result listStatements(array $args = [])
 * @method \GuzzleHttp\Promise\Promise listStatementsAsync(array $args = [])
 * @method \Aws\Result listTriggers(array $args = [])
 * @method \GuzzleHttp\Promise\Promise listTriggersAsync(array $args = [])
 * @method \Aws\Result listWorkflows(array $args = [])
 * @method \GuzzleHttp\Promise\Promise listWorkflowsAsync(array $args = [])
 * @method \Aws\Result putDataCatalogEncryptionSettings(array $args = [])
 * @method \GuzzleHttp\Promise\Promise putDataCatalogEncryptionSettingsAsync(array $args = [])
 * @method \Aws\Result putResourcePolicy(array $args = [])
 * @method \GuzzleHttp\Promise\Promise putResourcePolicyAsync(array $args = [])
 * @method \Aws\Result putSchemaVersionMetadata(array $args = [])
 * @method \GuzzleHttp\Promise\Promise putSchemaVersionMetadataAsync(array $args = [])
 * @method \Aws\Result putWorkflowRunProperties(array $args = [])
 * @method \GuzzleHttp\Promise\Promise putWorkflowRunPropertiesAsync(array $args = [])
 * @method \Aws\Result querySchemaVersionMetadata(array $args = [])
 * @method \GuzzleHttp\Promise\Promise querySchemaVersionMetadataAsync(array $args = [])
 * @method \Aws\Result registerSchemaVersion(array $args = [])
 * @method \GuzzleHttp\Promise\Promise registerSchemaVersionAsync(array $args = [])
 * @method \Aws\Result removeSchemaVersionMetadata(array $args = [])
 * @method \GuzzleHttp\Promise\Promise removeSchemaVersionMetadataAsync(array $args = [])
 * @method \Aws\Result resetJobBookmark(array $args = [])
 * @method \GuzzleHttp\Promise\Promise resetJobBookmarkAsync(array $args = [])
 * @method \Aws\Result resumeWorkflowRun(array $args = [])
 * @method \GuzzleHttp\Promise\Promise resumeWorkflowRunAsync(array $args = [])
 * @method \Aws\Result runStatement(array $args = [])
 * @method \GuzzleHttp\Promise\Promise runStatementAsync(array $args = [])
 * @method \Aws\Result searchTables(array $args = [])
 * @method \GuzzleHttp\Promise\Promise searchTablesAsync(array $args = [])
 * @method \Aws\Result startBlueprintRun(array $args = [])
 * @method \GuzzleHttp\Promise\Promise startBlueprintRunAsync(array $args = [])
 * @method \Aws\Result startCrawler(array $args = [])
 * @method \GuzzleHttp\Promise\Promise startCrawlerAsync(array $args = [])
 * @method \Aws\Result startCrawlerSchedule(array $args = [])
 * @method \GuzzleHttp\Promise\Promise startCrawlerScheduleAsync(array $args = [])
 * @method \Aws\Result startExportLabelsTaskRun(array $args = [])
 * @method \GuzzleHttp\Promise\Promise startExportLabelsTaskRunAsync(array $args = [])
 * @method \Aws\Result startImportLabelsTaskRun(array $args = [])
 * @method \GuzzleHttp\Promise\Promise startImportLabelsTaskRunAsync(array $args = [])
 * @method \Aws\Result startJobRun(array $args = [])
 * @method \GuzzleHttp\Promise\Promise startJobRunAsync(array $args = [])
 * @method \Aws\Result startMLEvaluationTaskRun(array $args = [])
 * @method \GuzzleHttp\Promise\Promise startMLEvaluationTaskRunAsync(array $args = [])
 * @method \Aws\Result startMLLabelingSetGenerationTaskRun(array $args = [])
 * @method \GuzzleHttp\Promise\Promise startMLLabelingSetGenerationTaskRunAsync(array $args = [])
 * @method \Aws\Result startTrigger(array $args = [])
 * @method \GuzzleHttp\Promise\Promise startTriggerAsync(array $args = [])
 * @method \Aws\Result startWorkflowRun(array $args = [])
 * @method \GuzzleHttp\Promise\Promise startWorkflowRunAsync(array $args = [])
 * @method \Aws\Result stopCrawler(array $args = [])
 * @method \GuzzleHttp\Promise\Promise stopCrawlerAsync(array $args = [])
 * @method \Aws\Result stopCrawlerSchedule(array $args = [])
 * @method \GuzzleHttp\Promise\Promise stopCrawlerScheduleAsync(array $args = [])
 * @method \Aws\Result stopSession(array $args = [])
 * @method \GuzzleHttp\Promise\Promise stopSessionAsync(array $args = [])
 * @method \Aws\Result stopTrigger(array $args = [])
 * @method \GuzzleHttp\Promise\Promise stopTriggerAsync(array $args = [])
 * @method \Aws\Result stopWorkflowRun(array $args = [])
 * @method \GuzzleHttp\Promise\Promise stopWorkflowRunAsync(array $args = [])
 * @method \Aws\Result tagResource(array $args = [])
 * @method \GuzzleHttp\Promise\Promise tagResourceAsync(array $args = [])
 * @method \Aws\Result untagResource(array $args = [])
 * @method \GuzzleHttp\Promise\Promise untagResourceAsync(array $args = [])
 * @method \Aws\Result updateBlueprint(array $args = [])
 * @method \GuzzleHttp\Promise\Promise updateBlueprintAsync(array $args = [])
 * @method \Aws\Result updateClassifier(array $args = [])
 * @method \GuzzleHttp\Promise\Promise updateClassifierAsync(array $args = [])
 * @method \Aws\Result updateColumnStatisticsForPartition(array $args = [])
 * @method \GuzzleHttp\Promise\Promise updateColumnStatisticsForPartitionAsync(array $args = [])
 * @method \Aws\Result updateColumnStatisticsForTable(array $args = [])
 * @method \GuzzleHttp\Promise\Promise updateColumnStatisticsForTableAsync(array $args = [])
 * @method \Aws\Result updateConnection(array $args = [])
 * @method \GuzzleHttp\Promise\Promise updateConnectionAsync(array $args = [])
 * @method \Aws\Result updateCrawler(array $args = [])
 * @method \GuzzleHttp\Promise\Promise updateCrawlerAsync(array $args = [])
 * @method \Aws\Result updateCrawlerSchedule(array $args = [])
 * @method \GuzzleHttp\Promise\Promise updateCrawlerScheduleAsync(array $args = [])
 * @method \Aws\Result updateDatabase(array $args = [])
 * @method \GuzzleHttp\Promise\Promise updateDatabaseAsync(array $args = [])
 * @method \Aws\Result updateDevEndpoint(array $args = [])
 * @method \GuzzleHttp\Promise\Promise updateDevEndpointAsync(array $args = [])
 * @method \Aws\Result updateJob(array $args = [])
 * @method \GuzzleHttp\Promise\Promise updateJobAsync(array $args = [])
 * @method \Aws\Result updateMLTransform(array $args = [])
 * @method \GuzzleHttp\Promise\Promise updateMLTransformAsync(array $args = [])
 * @method \Aws\Result updatePartition(array $args = [])
 * @method \GuzzleHttp\Promise\Promise updatePartitionAsync(array $args = [])
 * @method \Aws\Result updateRegistry(array $args = [])
 * @method \GuzzleHttp\Promise\Promise updateRegistryAsync(array $args = [])
 * @method \Aws\Result updateSchema(array $args = [])
 * @method \GuzzleHttp\Promise\Promise updateSchemaAsync(array $args = [])
 * @method \Aws\Result updateTable(array $args = [])
 * @method \GuzzleHttp\Promise\Promise updateTableAsync(array $args = [])
 * @method \Aws\Result updateTrigger(array $args = [])
 * @method \GuzzleHttp\Promise\Promise updateTriggerAsync(array $args = [])
 * @method \Aws\Result updateUserDefinedFunction(array $args = [])
 * @method \GuzzleHttp\Promise\Promise updateUserDefinedFunctionAsync(array $args = [])
 * @method \Aws\Result updateWorkflow(array $args = [])
 * @method \GuzzleHttp\Promise\Promise updateWorkflowAsync(array $args = [])
 */
class GlueClient extends AwsClient {}
